
<?php 

    /*
        Last modified - 16-04-2020
    */
    
    class SessionNotFoundException extends Exception
    {
    }

    class SessionExpiredException extends Exception
    {
    }


    /*
    CREATE TABLE `ntrca_2146`.`session_base` (
        `id` int(11) NOT NULL,
        `sessionId` varchar(50) NOT NULL,
        `sessionName` varchar(100) NOT NULL,
        `sessionDatetime` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ALTER TABLE `ntrca_2146`.`session_base` ADD PRIMARY KEY (`id`);
    ALTER TABLE `ntrca_2146`.`session_base` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    =========================================================
    CREATE TABLE `ntrca_2146_applicants`.`session_values` (
        `id` int(11) NOT NULL,
        `sessionId` varchar(50) NOT NULL,
        `keyName` varchar(100) NOT NULL,
        `keyValue` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    ALTER TABLE `ntrca_2146_applicants`.`session_values` ADD PRIMARY KEY (`id`);
    ALTER TABLE `ntrca_2146_applicants`.`session_values` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    */
    class SessionBase{
      
        private $sessionId = "";
        private $db = null;
        private $swiftDatetime = null;
        private $defaultSessionTimeoutValue = 0;

        
        /**
         * constructor()
         * 
         * @param ZeroSQL $zeroSql Instance of ZeroSQL.
         * 
         * @param SwiftDatetime $swiftDatetime Instance of SwiftDatetime
         * 
         * @param int $defaultDuration Default session timeout value in seconds. Default value is 7200 seconds (120 minutes). 
         *          
         * 
         */
        public function __construct(ZeroSQL $zeroSql, SwiftDatetime $swiftDatetime,int $defaultDuration = 7200) {
            $this->db = $zeroSql;
            $this->swiftDatetime = $swiftDatetime;
            $this->defaultSessionTimeoutValue = $defaultDuration;
        }

        public function __destruct(){ }

        

        /**
         * start()
         * 
         * Creates a new session.
         * Call this method only once in a site after a successfull user validation i.e. in login page.
         * 
         * @param string $sessionName user's ID or email or loginName.
         * 
         * @return this
         */
        public function start($sessionName){
            $sql = "SELECT sessionId, sessionDatetime 
                    FROM session_base 
                    WHERE sessionName='$sessionName'";

            $sessionBase = $this->db->select($sql)->fromSQL()->singleOrNull();
            
            $now = $this->swiftDatetime->now()->asYmdHis();
            
            if($sessionBase == null){
                $this->sessionId = uniqid('', true);
                $sql = "INSERT INTO session_base(sessionId, sessionName, sessionDatetime) 
                        VALUES('$this->sessionId','$sessionName','$now')";
                $this->db->insert($sql)->fromSQL()->execute();
               
            }
            else{
                $this->sessionId = $sessionBase->sessionId;
                $sql = "UPDATE session_base SET sessionDatetime='$now' WHERE sessionId='$sessionBase->sessionId'";
                $this->db->update($sql)->fromSQL()->execute();
            }

            return $this;
        }

       /**
        *@return string sessionId 
        */
        public function getSessionId(){
            return $this->sessionId;
        }

         /**
         * continue()
         * 
         * Continues a session that was created prevously.
         * Call this method in every subsequent pages.
         * 
         * @param string $sessionId
         * 
         * @return this
         * 
         * @throws SessionNotFoundException if sessionId not found.
         * @throws SessionExpiredException if session expires.
         */
        public function continue($sessionId){
            //call this function on every subsequent page except login page
            
            $sql = "SELECT *  
                    FROM session_base 
                    WHERE sessionId = '$sessionId'";

            $sessionBase = $this->db->select($sql)->fromSQL()->singleOrNull();
            
            if($sessionBase == null){
                throw new SessionNotFoundException("Session not found.");
            }
            
            $now = $this->swiftDatetime->now()->asYmdHis();
            $now = strtotime($now);

            $lastActivity = $this->swiftDatetime->input($sessionBase->sessionDatetime)->asYmdHis();
            $lastActivity = strtotime($lastActivity);
           
            $diff = $now - $lastActivity;
            if($diff > $this->defaultSessionTimeoutValue){
                //delete from session_base table
                $this->_deleteAllSessionData($sessionId);
                throw new SessionExpiredException("Session expired.");
            }
         
            //all are okay. finally sets.
            $this->sessionId = $sessionId;
            $this->_updateLastActivityDatetime();
            return $this;
        }

        #region set in session_values table
            public function setString(string $key, string $value){
                if(!isset($key) || empty($key)){
                    throw new Exception("Session key name required");
                }

                if(!isset($value) || empty($value)){
                    throw new Exception("Session key value required");
                }

                try {
                        $this->_set($key, $value);
                } catch (\ZeroException $exp) {
                    throw $exp;
                }
            }

            
            public function setJsonObject(string $key, mixed $value){
                if(!isset($key) || empty($key)){
                    throw new Exception("Session key name required");
                }

                if(!isset($value) || empty($value)){
                    throw new Exception("Session key value required");
                }

                $value =  json_encode($value,JSON_FORCE_OBJECT);

                try {
                        $this->_set($key, $value);
                } catch (\ZeroException $exp) {
                    throw $exp;
                }
            }

            
            public function setJsonArray(string $key, mixed $value){
                if(!isset($key) || empty($key)){
                    throw new Exception("Session key name required");
                }

                if(!isset($value) || empty($value)){
                    throw new Exception("Session key value required");
                }

                $value =  json_encode($value);
            
                try {
                        $this->_set($key, $value);
                } catch (\ZeroException $exp) {
                    throw $exp;
                }
            }

            //used in setString(), setJsonObject(),  setJsonArray()
            private function _set(string $key, string $value){
                $sql = "SELECT * FROM session_values WHERE sessionId='$this->sessionId' AND keyName = '$key'";
                $sessionValue = $this->db->select($sql)->fromSQL()->singleOrNull();
                if($sessionValue == null){
                    $sql = "INSERT INTO session_values(sessionId, keyName, keyValue) VALUES('$this->sessionId', '$key', '$value')";
                    $this->db->insert($sql)->fromSQL()->execute();
                }
                else{
                    $sql = "UPDATE session_values SET keyValue = '$value' WHERE id='$sessionValue->id'";
                    $this->db->update($sql)->fromSQL()->execute();
                }

                //finally update last activity time
                $this->_updateLastActivityDatetime();
            }

        #endregion

        #region get from session_values table
            public function getString(string $key){
                if(!isset($key) || empty($key)){
                    throw new Exception("Session key name required");
                }

                $sql = "SELECT keyValue FROM session_values WHERE sessionId='$this->sessionId' AND keyName = '$key'";
                $sessionStore = $this->db->select($sql)->fromSQL()->singleOrNull();

                //finally update last activity time
                $this->_updateLastActivityDatetime();
                if($sessionStore == null){
                    return null;
                }
                
                return $sessionStore->keyValue;

            }

            /**
             * @return stdClass 
             */
            public function getJsonObject(string $key){
                if(!isset($key) || empty($key)){
                    throw new Exception("Session key name required");
                }

                $sessionStore = $this->_get($key);
                if($sessionStore == null) return null;
                
                return json_decode($sessionStore->keyValue,false);

            }

            public function getJsonArray(string $key){
                if(!isset($key) || empty($key)){
                    throw new Exception("Session key name required");
                }

                //finally update last activity time
                $this->_updateLastActivityDatetime();
               
                $sessionStore = $this->_get($key);
                if($sessionStore == null) return null;
                
                return json_decode($sessionStore->keyValue,true);

            }

            private function _get(string $key){
                $sql = "SELECT keyValue FROM session_values WHERE sessionId='$this->sessionId' AND keyName = '$key'";
                return $this->db->select($sql)->fromSQL()->singleOrNull();
            }
        #endregion
     
        //remove from sessoin_values table
        public function unset(string $key){
            $sql = "DELETE * FROM session_values WHERE sessionId='$this->sessionId' AND keyName = '$key'";
            $this->db->delete($sql)->fromSQL()->execute();
             //finally update last activity time
             $this->_updateLastActivityDatetime();
        }

        private function _updateLastActivityDatetime(){
            $now = $this->swiftDatetime->now()->asYmdHis();
            $sql = "UPDATE session_base SET sessionDatetime='$now' WHERE sessionId='$this->sessionId'";
            $this->db->update($sql)->fromSQL()->execute();
        }

        //delete all data from session_base and session_values
        public function close(){
            $this->_deleteAllSessionData($this->sessionId);
        }

        //alias of close()
        ////delete all data from session_base and session_values
        public function destroy(){
            $this->close();
        }

        private function _deleteAllSessionData(string $sessionId){
            //delete from session_base table
            $sql = "DELETE FROM session_base WHERE sessionId='$sessionId'";
            $this->db->delete($sql)->fromSQL()->execute();

             //delete from session_values table
             $sql = "DELETE FROM session_values WHERE sessionId='$sessionId'";
             $this->db->delete($sql)->fromSQL()->execute();
             unset($this->sessionId);
        }

    } //<--class
?>