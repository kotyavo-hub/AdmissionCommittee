$(document).ready(function(){

    $('#smartwizard').smartWizard({

        enableFinishButton: true, // makes finish button enabled always,
        lang: { next: 'Далее', previous: 'Назад'},
        onFinish: onFinishCallback,
        onCancel: onCancelCallback,
        labelFinish:'Finish',  // label for Finish button
        labelCancel:'Cancel'
    })

    function onFinishCallback(){
        alert('finish');
    }

    function onCancelCallback(){
        alert('cancel');
    }
});