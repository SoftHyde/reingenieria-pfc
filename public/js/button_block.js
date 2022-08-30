$(document).ready(function() {
    $("button[name='btn_vote']").prop("disabled", true);
    $("input[type='radio']").change(function(){
        $("button[name='btn_vote']").prop("disabled", false);
    });
});