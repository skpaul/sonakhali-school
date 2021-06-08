function IsMobileNumberValid(mobileNumber) {
    mobileNumber = mobileNumber.trim();

    if (mobileNumber == '') { return false; }
    if (isNaN(mobileNumber)) { return false; }

    if (mobileNumber.length < 10) { return false; }

    var operatorCodes = ["013", "014" ,"015", "016", "017", "018", "019"];

    //if the number is 1711781878, it's length must be 10 digits
    if (mobileNumber.startsWith("1")) {
        var firstTwoDigits = mobileNumber.substr(0, 2); //returns 17, 18 etc,
        var operatorCode = "0" + firstTwoDigits; //Make first two digits a valid operator code with adding 0.
        if (!operatorCodes.includes(operatorCode)) { return false; }
        return true;
    }

    if (mobileNumber.startsWith("01")) {
        //if the number is 01711781878, it's length must be 11 digits
        if (mobileNumber.length != 11) { return false; }
        var operatorCode = mobileNumber.substr(0, 3); //returns 017, 018 etc,
        if (!operatorCodes.includes(operatorCode)) { return false; }
        return true;
    }

    if (mobileNumber.startsWith("8801")) {
        //if the number is 8801711781878, it's length must be 13 digits
        if (mobileNumber.length != 13) { return false; }
        var operatorCode = mobileNumber.substr(2, 3); //returns 017, 018 etc,
        if (!operatorCodes.includes(operatorCode)) { return false; }
        return true;
    }

    return false;
}