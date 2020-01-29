$(function(){
    // $( ".draggable" ).draggable({ scroll: true });
    $(".panel_table").tableDnD();

    $(".generate-feed").click(function(){
        $.get("save.php", function(){
            alert("Feed is generated successfully");
             location.reload();
        });
    });
});