$("#dropdownMenuButton").css("background-color", "red");
setInterval(function () {
    $("#dropdownMenuButton").css("background-color", function () {
        this.switch = !this.switch
        return this.switch ? "red" : ""
    });
}, 1000);
