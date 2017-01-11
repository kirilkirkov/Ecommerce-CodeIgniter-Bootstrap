if ($(window).width() > 767) {
    var left_side_width = $('.left-side').width();
    $("#brand").css("width", left_side_width - 1);
}
$(window).resize(function () {
    if ($(window).width() > 767) {
        var left_side_width = $('.left-side').width();
        $("#brand").css("width", left_side_width - 1);
    }
});
$(document).ready(function () {
    $(".h-settings").click(function () {
        $(".settings").toggle("slow", function () {
            $("i.fa.fa-cogs").addClass('fa-spin');
            if ($(".settings").is(':visible')) {
                $("i.fa.fa-cogs").addClass('fa-spin');
            } else {
                $("i.fa.fa-cogs").removeClass('fa-spin');
            }
        });
    });
});
function changePass() {
    var new_pass = $('[name="new_pass"]').val();
    if (jQuery.trim(new_pass).length > 3) {
        $.ajax({
            type: "POST",
            url: urls.changePass,
            data: {new_pass: new_pass}
        }).done(function (data) {
            if (data == '1') {
                $("#pass_result").fadeIn(500).delay(2000).fadeOut(500);
            } else {
                alert('Password cant change!');
            }
        });
    } else {
        alert('Too short pass!');
    }
}
$("#dev-zone").click(function () {
    $(".toggle-dev").slideToggle("slow");
});

$("a.confirm-delete").click(function (e) {
    e.preventDefault();
    var lHref = $(this).attr('href');
    bootbox.confirm({
        message: "Are you sure want to delete?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                window.location.href = lHref;
            }
        }
    });
});
$("a.confirm-save").click(function (e) {
    e.preventDefault();
    var formId = $(this).data('form-id');
    bootbox.confirm({
        message: "Are you sure want to save?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                document.getElementById(formId).submit();
            }
        }
    });
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
//xs hidden categories
$("#show-xs-nav").click(function () {
    $(".sidebar-menu").toggle("slow", function () {
        if ($(this).is(":visible") == true) {
            $("#show-xs-nav .hidde-sp").show();
            $("#show-xs-nav .show-sp").hide();
        } else {
            $("#show-xs-nav .hidde-sp").hide();
            $("#show-xs-nav .show-sp").show();
        }
    });
});

// Calculator starts here
var Calculator = {

    results_id: 'calculator-result',
    results_value: '0',
    memory_id: 'calculator-screen',
    memory_value: '',
    history_id: 'calc-history-list',
    history_value: [],

    SUM: ' + ',
    MIN: ' - ',
    DIV: ' / ',
    MULT: ' * ',
    PROC: '%',
    SIN: 'sin(',
    COS: 'cos(',
    MOD: ' mod ',
    BRO: '(',
    BRC: ')',

    calculate: function () {
        this.history_value.push(this.memory_value);
        this.results_value = this.engine.exec(this.memory_value);
        this.add_to_history();
        this.refresh();
    },

    put: function (value) {
        this.memory_value += value;
        this.update_memory();
    },

    reset: function () {
        this.memory_value = '';
        this.results_value = '0';
        this.clear_history();
        this.refresh();
    },

    refresh: function () {
        this.update_result();
        this.update_memory();
    },

    update_result: function () {
        document.getElementById(this.results_id).innerHTML = this.results_value;
    },

    update_memory: function () {
        document.getElementById(this.memory_id).innerHTML = this.memory_value;
    },

    add_to_history: function () {
        if (isNaN(this.results_value) == false) {
            var div = document.createElement('li');
            div.innerHTML = this.memory_value + ' = ' + this.results_value;

            var tag = document.getElementById(this.history_id);
            tag.insertBefore(div, tag.firstChild);
        }
    },

    clear_history: function () {
        $('#' + this.history_id + '> li').remove();
    },

    engine: {
        exec: function (value) {
            try {
                return eval(this.parse(value))
            } catch (e) {
                return e
            }
        },

        parse: function (value) {
            if (value != null && value != '') {
                value = this.replaceFun(value, Calculator.PROC, '/100');
                value = this.replaceFun(value, Calculator.MOD, '%');
                value = this.addSequence(value, Calculator.PROC);

                value = this.replaceFun(value, 'sin', 'Math.sin');
                value = this.replaceFun(value, 'cos', 'Math.cos');
                return value;
            } else
                return '0';
        },

        replaceFun: function (txt, reg, fun) {
            return txt.replace(new RegExp(reg, 'g'), fun);
        },

        addSequence: function (txt, fun) {
            var list = txt.split(fun);
            var line = '';

            for (var nr in list) {
                if (line != '') {
                    line = '(' + line + ')' + fun + '(' + list[nr] + ')';
                } else {
                    line = list[nr];
                }
            }
            return line;
        }
    }
}
$(document).ready(function () {
    $("#calculator .btn").click(function (e) {
        e.preventDefault();
        if ($(this).data('constant') != undefined) {
            return Calculator.put(Calculator[$(this).data('constant')]);
        }
        if ($(this).data('method') != undefined) {
            return Calculator[$(this).data('method')]();
        }
        return Calculator.put($(this).html());
    });
});
// Calculator code finish here

// Password strenght starts here
$(document).ready(function () {
    //PassStrength 
    checkPass();
    $(".new-pass-field").on('keyup', function () {
        checkPass();
    });

    //PassGenerator
    $('.generate-pwd').pGenerator({
        'bind': 'click',
        'passwordLength': 9,
        'uppercase': true,
        'lowercase': true,
        'numbers': true,
        'specialChars': false,
        'onPasswordGenerated': function (generatedPassword) {
            $(".new-pass-field").val(generatedPassword);
            checkPass();
        }
    });
});

//toggle in settings
$(document).ready(function () {
    $('.toggle-changer').change(function () {
        var myValue;
        if ($(this).prop('checked') == false) {
            myValue = '0';
        } else {
            myValue = '1';
        }
        var myData = $(this).data('for-field');
        $('[name="' + myData + '"]').val(myValue);
    });
});

//themes in settings
$(document).ready(function () {
    $('.select-law-theme').click(function () {
        $('.ok').hide();
        $(this).children('.ok').show();
        var theme_name = $(this).data('law-theme');
        $('[name="theme"]').val(theme_name);
    });
});

//templates chooser
$('.choose-template').click(function () {
    var template_name = $(this).data('template-name');
    $('#saveTemplate .template-name').val(template_name);
});

//Edit Shop Categories
var indicEditCategorie;
var forIdEditCategorie;
var abbrEditCategorie;
$('.editCategorie').click(function () {
    indicEditCategorie = $(this).data('indic');
    forIdEditCategorie = $(this).data('for-id');
    abbrEditCategorie = $(this).data('abbr');
    var position = $(this).position();
    $('#categorieEditor').css({top: position.top, left: position.left, display: 'block'});
    $('#categorieEditor input').val($('#indic-' + indicEditCategorie).text());
});
$('.closeEditCategorie').click(function () {
    $('#categorieEditor').hide();
});
$('.saveEditCategorie').click(function () {
    $('#categorieEditor .noSaveEdit').hide();
    $('#categorieEditor .yesSaveEdit').css({display: 'inline-block'});
    var newValueFromEdit = $('[name="new_value"]').val();
    $.ajax({
        type: "POST",
        url: urls.editShopCategorie,
        data: {for_id: forIdEditCategorie, abbr: abbrEditCategorie, type: 'shop_categorie', name: newValueFromEdit}
    }).done(function (data) {
        $('#categorieEditor .noSaveEdit').show();
        $('#categorieEditor .yesSaveEdit').hide();
        $('#categorieEditor').hide();
        $('#indic-' + indicEditCategorie).text(newValueFromEdit);
    });
});