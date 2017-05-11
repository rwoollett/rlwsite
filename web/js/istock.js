/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function changeOption(objOption, objSelect) {
    objOption.value = objSelect[objSelect.selectedIndex].value;
    return true;
}

function changeOptionCost(objOption, objCost, objSelect) {
    intSplitPos = objSelect[objSelect.selectedIndex].value.indexOf(",");
    intEndPos = objSelect[objSelect.selectedIndex].value.length;
    objOption.value = objSelect[objSelect.selectedIndex].value.substring(0, intSplitPos);
    objCost.value = objSelect[objSelect.selectedIndex].value.substring(intSplitPos + 1, intEndPos);
    return true;
}

$('form').filter(function () {
    return this.id.match(/^searchstocklist/);
}).on("beforeSubmit", function () {
    // send data to actionSave by ajax request.
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find('.has-error').length)
    {
        return false;
    }
    // submit form
    jQuery.ajax({
        url: form.attr('action'),
        type: 'post',
        data: form.serialize(),
        success: function (response)
        {
            var getupdatedata = $(response).find('#filter_id_test');
            // $.pjax.reload('#note_update_id'); for pjax update
            //$('#yiiikap').html(getupdatedata);
            alert("success: Cart add done filter form find!!");
            console.log(getupdatedata);
        },
        error: function ()
        {
            console.log('internal server error');
        }
    });
    return false;
});

