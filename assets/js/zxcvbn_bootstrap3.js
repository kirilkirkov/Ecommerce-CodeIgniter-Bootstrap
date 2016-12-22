function checkPass() {
    var less_days = 5; //Too short before days to crack
    var more_days = 30; //Very strong after days to crack
    var password = $(".new-pass-field").val();


    var tooshort_before = (60 * 60 * 24) * less_days;
    var verystrong_after = (60 * 60 * 24) * more_days;
    var analysis = zxcvbn(password);//Analys from zxcvbn Lib
    var crack_time_in_seconds = analysis.crack_time;//Time in seconds for crack

    if (crack_time_in_seconds == 0) {
        $(".progress-bar").css({"width": "0"});
    } else if (crack_time_in_seconds < tooshort_before) {
        $(".progress-bar").css({"width": "15%"});
        $(".progress-bar").addClass("progress-bar-danger").removeClass('progress-bar-success').removeClass('progress-bar-warning');
        $(".progress-bar").text('Too Weak !');
        return false;
        //this will not work here.. you can set password you want.. i will dont stop you because its weak!
    } else if (crack_time_in_seconds > tooshort_before && crack_time_in_seconds <= tooshort_before * 2) {
        $(".progress-bar").css({"width": "25%"});
        $(".progress-bar").addClass("progress-bar-warning").removeClass('progress-bar-success').removeClass('progress-bar-danger');
        $(".progress-bar").text('Normal');
        return true;
    } else if (crack_time_in_seconds > tooshort_before * 2 && crack_time_in_seconds <= tooshort_before * 4) {
        $(".progress-bar").css({"width": "50%"});
        $(".progress-bar").addClass("progress-bar-warning").removeClass('progress-bar-success').removeClass('progress-bar-danger');
        $(".progress-bar").text('Medium');
        return true;
    } else if (crack_time_in_seconds > tooshort_before * 4 && crack_time_in_seconds <= verystrong_after) {
        $(".progress-bar").css({"width": "75%"});
        $(".progress-bar").addClass("progress-bar-warning").removeClass('progress-bar-success').removeClass('progress-bar-danger');
        $(".progress-bar").text('Strong');
        return true;
    } else if (crack_time_in_seconds > verystrong_after) {
        $(".progress-bar").css({"width": "100%"});
        $(".progress-bar").addClass("progress-bar-success").removeClass('progress-bar-warning').removeClass('progress-bar-danger');
        $(".progress-bar").text('Very Strong !');
        return true;
    }
}