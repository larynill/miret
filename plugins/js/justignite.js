function days() {
    var a = $("#datepicker_start").datepicker('getDate').getTime(),
        b = $("#datepicker_end").datepicker('getDate').getTime(),
        c = 24*60*60*1000,
        diffDays = Math.round(Math.abs((a - b)/(c)));
    console.log(diffDays); //show difference
}

function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth() + 1;
    months += d2.getMonth();
    return months + 1;
}