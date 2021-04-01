const cloneInputGroup = (templateSelector, containerSelector) => {
    const cloneGroup = $(templateSelector).first().clone();
    cloneGroup.find('input').val('');
    cloneGroup.appendTo(containerSelector);
}

const removeInputGroup = (containerSelector, groupSelector, minCount = 1) => {
    const inputGroups = $(containerSelector).find(groupSelector);
    if (inputGroups.length > minCount) {
        inputGroups.last().remove();
    }
}

window.getFromData = () => {
    const fd = new FormData(document.forms.applyingForm);
    for(let [name, value] of fd) {
        console.log(`${name} = ${value}`);
    }
};

$(document).ready(function(){
    $('#toggleSpecRights').change(function () {
        const displayStyle = ($(this).is(':checked')) ? 'block' : 'none';
        $('#specRightsBlock').css('display', displayStyle);
    })

    $('#addSpecRightsInputButton').click(function () {
        cloneInputGroup('.spec_rights_inputs', '#specRightsInputsGroups')
    })

    $('#removeSpecRightsInputButton').click(function () {
        removeInputGroup('#specRightsInputsGroups', '.spec_rights_inputs')
    })

    $('#togglePreemRights').change(function () {
        const displayStyle = ($(this).is(':checked')) ? 'block' : 'none';
        $('#preemRightsBlock').css('display', displayStyle);
    })

    $('#addPreemRightsInputButton').click(function () {
        cloneInputGroup('.preem_rights_input_group', '#preemRightsInputsGroups')
    })

    $('#removePreemRightsInputButton').click(function () {
        removeInputGroup('#preemRightsInputsGroups', '.preem_rights_input_group')
    })

    $('#toggleIndividAchievs').change(function () {
        const displayStyle = ($(this).is(':checked')) ? 'block' : 'none';
        $('#individAchievsBlock').css('display', displayStyle);
    })

    $('#addIndividAchievsInputButton').click(function () {
        cloneInputGroup('.individ_achievs_input_group', '#individAchievsInputsGroups')
    })

    $('#removeIndividAchievsInputButton').click(function () {
        removeInputGroup('#individAchievsInputsGroups', '.individ_achievs_input_group')
    })

    $('#addExamInputsGroupButton').click(function () {
        cloneInputGroup('.exam_inputs_group', '#examInputsGroups')
    })

    $('#removeExamInputsGroupButton').click(function () {
        removeInputGroup('#examInputsGroups', '.exam_inputs_group', 3)
    })

    $('#smartwizard').smartWizard({
        autoAdjustHeight: false,
        enableFinishButton: true, // makes finish button enabled always,
        lang: { next: 'Далее', previous: 'Назад', finish: 'Отправить заявление'},
        onFinish: onFinishCallback,
        onCancel: onCancelCallback,
        labelFinish:'Завершить',  // label for Finish button
        labelCancel:'Отмена'
    })

    function onFinishCallback(){
        alert('finish');
    }

    function onCancelCallback(){
        alert('cancel');
    }
});