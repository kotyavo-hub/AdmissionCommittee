/** Сброс шагов при перезагрузке страницы */
window.location.hash = '';

/**
 * Функция для кланнирования блоков по шаблоны
 *
 * @param groupClass {string}
 * @param containerSelector {string}
 * @param nameInputsArray {string}
 */
const cloneInputGroup = (groupClass, containerSelector, nameInputsArray = '') => {
    const cloneGroup = $(groupClass + '_template').first().clone();

    const elemClass = groupClass.substr(1);

    cloneGroup.removeClass(elemClass + '_template');
    cloneGroup.addClass(elemClass);
    cloneGroup.show();

    const groupsCount = $(containerSelector).find(groupClass).length;

    if (nameInputsArray) {
        cloneGroup.find('input, select').each(function () {
            $(this).attr('name', $(this).attr('data-name').replace(
                /.+?\[[^\]]*\]/,
                nameInputsArray + '[' +(groupsCount)+']'
            ));
        })
    }

    cloneGroup.find('input').val('');
    cloneGroup.appendTo(containerSelector);

    setInputArrayValidation();
}

/**
 * Функция для удаления элемента блока
 *
 * @param containerSelector
 * @param groupSelector
 * @param minCount
 */
const removeInputGroup = (containerSelector, groupSelector, minCount = 1) => {
    const inputGroups = $(containerSelector).find(groupSelector);
    if (inputGroups.length > minCount) {
        inputGroups.last().remove();
    }
}

/**
 * Функция обновления на шаге выбора конкурсов
 *
 * @param selector
 * @param data
 * @param indexKey
 * @param valueKey
 * @returns {boolean}
 */
const updateSelect = (selector, data, indexKey, valueKey) => {
    const select = $(selector);
    select.empty();

    if (!data.length)
        return false;

    data.forEach(item => {
        select.append($("<option></option>", {value: item[indexKey], text: item[valueKey]}));
    });

    select.trigger('change');

    return true;
}

/**
 * Функция для установки правил элементов имя которых является многомерным массивом
 */
const setInputArrayValidation = () => {
    const preemInputs = $(
        'input[name^="specRights"], ' +
        'select[name^="specRights"], ' +
        'input[name^="preemRights"], ' +
        'select[name^="preemRights"] ' +
        'input[name^="individAchievs"], ' +
        'select[name^="individAchievs"] '
    );

    preemInputs.filter('select[name$="[docType]"]').each(function() {
        $(this).rules("add", {
            required: true,
        });
    });

    preemInputs.filter('input[name$="[document]"]').each(function() {
        $(this).rules("add", {
            required: true,
            accept: 'application/pdf'
        });
    });

    preemInputs.filter('input[name$="[docSeria]"]').each(function() {
        $(this).rules("add", {
            required: true
        });
    });

    preemInputs.filter('input[name$="[docNumber]"]').each(function() {
        $(this).rules("add", {
            required: true
        });
    });

    preemInputs.filter('input[name$="[docDate]"]').each(function() {
        $(this).rules("add", {
            required: true
        });
    });

    preemInputs.filter('input[name$="[docOrganization]"]').each(function() {
        $(this).rules("add", {
            required: true
        });
    });

    const examInputs = $(
        'input[name^="exams"], ' +
        'select[name^="exams"]'
    );

    jQuery.validator.addMethod("requiredIfNotCheckBoxExam", function(value, element, params) {
        const group = element.closest('.exam_inputs_group');
        const checkbox = $(group).find('input[name$="[passingLeaverTests]"]').first();
        console.log(checkbox.val());
        return $(element).val() || (checkbox && checkbox.prop("checked"));
    }, jQuery.validator.format("Введите свой бал если не сдаете вступительные испытания."));

    examInputs.filter('select[name$="[examId]"]').each(function() {
        $(this).rules("add", {
            required: true,
        });
    });

    examInputs.filter('input[name$="[result]"]').each(function() {
        $(this).rules("add", {
            requiredIfNotCheckBoxExam: true,
            min: 0,
            max: 100
        });
    });
};


/**
 * Функция для установки подсветки после валидации поля
 *
 * @param {*|jQuery.fn.init|jQuery|HTMLElement} element
 * @param {boolean} isInvalid
 */
const setHighlight = (element, isInvalid) => {
    const removedClass = (isInvalid) ? 'is-valid' : 'is-invalid';
    const addedClass = (isInvalid) ? 'is-invalid' : 'is-valid';

    switch (element.type) {
        case 'radio':
            $(element).closest('.form-group').find('input[name=' + element.name + ']').each(function () {
                $(this).removeClass(removedClass);
                $(this).addClass(addedClass);
            });
            break;
        case 'file':
            $(element).closest('.file-drop-area').removeClass(removedClass);
            $(element).closest('.file-drop-area').addClass(addedClass);
            break;
        default:
            $(element).removeClass(removedClass);
            $(element).addClass(addedClass);
    }
};

/**
 * Функция получения доступных специальностей
 *
 * @param successCallback
 */
const getSpecialityList = (successCallback) => {
    const form = $('#applyingForm');
    $.ajax({
        async: false,
        url: '/apiV1/speciality/specialties_available_by_leaver/',
        method: 'post',
        dataType: 'html',
        data: form.serialize(),
        success: function(result){
            result = JSON.parse(result);
            if (successCallback)
                successCallback(result);
        }
    });
};

/**
 *
 * @param inputsBlock
 * @param isChecked
 */
const toggleIgnoreBlocks = (inputsBlock, isChecked) => {
    inputsBlock.attr('data-validation', (isChecked) ? null : 'ignore');
};

const toggleDisplayBlock = (block ,value) => {
    if (value) {
        $(block).show('slow');
    } else {
        $(block).hide('slow');
    }
};

window.updateTest = () => {
    window.getSpecialityList(function (result) {
        updateSelect('#specialitySelect', result.data, 'specialityCode', 'speciality')
    });
};

$(document).ready(function(){

    /** меняем отображение в полях файлов */
    $(document).on('change', '.file-input', function() {
        const filesCount = $(this)[0].files.length;

        const textBox = $(this).prev();

        if (filesCount === 1) {
            const fileName = $(this).val().split('\\').pop();
            textBox.text(fileName);
        } else {
            textBox.text(filesCount + ' файлов выбрано');
        }
    });

    /** Конфиг правил валидатора */
    const validationFieldsRule = {
        urov: 'required',
        name: 'required',
        surName: 'required',
        gender: 'required',
        citizenCode: 'required',
        docTypeId: 'required',
        docSeria: {
            required: true,
            number: true,
        },
        docNo: 'required',
        docDistr: 'required',
        docDate: 'required',
        docFMSCode: 'required',
        bornDate: 'required',
        mobtel: 'required',
        hometel: 'required',
        bCountry: 'required',
        bAddress: 'required',
        rCountry: 'required',
        rAddress: 'required',
        fCountry: 'required',
        fAddress: 'required',
        passportFile: {
            required: true,
            accept: 'application/pdf'
        },
        schoolTypeCode: 'required',
        schoolNumber: 'required',
        lang: 'required',
        educDocTypeCode: 'required',
        educDocSeria: 'required',
        educDocNo: 'required',
        educDocDate: 'required',
        educDocDistr: 'required',
        supplementNo: 'required',
        supplementSeria: 'required',
        sCountry: 'required',
        sAddress: 'required',
        attres3: 'required',
        attres4: 'required',
        attres5: 'required',
        educDocFile: {
            required: true,
            accept: 'application/pdf'
        },
        priorityVUZ: 'required',
        countVUZ: 'required',
        specRights: 'required',
        confirm5vuz: 'required',
        confirmUseSpecRight: 'required',
        confirmVuzRules: 'required',
        confirmApplyingRules: 'required',
        confirmDataProcessing: 'required',
        correctInfoFile: {
            required: true,
            accept: 'application/pdf'
        },
    };

    /** Конфиг сообщений валидации */
    const validationMessages = {
        passportFile: {
            accept: 'Пожалуйста, загрузите файл с расширением ".pdf".'
        },
        educDocFile: {
            accept: 'Пожалуйста, загрузите файл с расширением ".pdf".'
        },
    }

    const applyingForm = $('#applyingForm');

    /** Инициализация валидации **/
    applyingForm.validate({
        rules: validationFieldsRule,
        messages: validationMessages,
        ignore: ':hidden, [data-validation="ignore"] input',
        highlight: function (element) {
            setHighlight(element, true);
        },
        unhighlight: function (element) {
            setHighlight(element, false);
        },
        errorPlacement: function (error, element) {
            $(element).closest('.form-group').find('.invalid-feedback').text(error.text());
        },
        success: function (label, element) {
            $(element).closest('.form-group').find('.invalid-feedback').text('');
        }
    })

    setInputArrayValidation();

    /** Валидация перед отправкой формы */
    $(applyingForm).on('submit', function(e) {
        applyingForm.validate().settings.ignore = '[data-validation="ignore"] input';
        if (!applyingForm.valid()) {
            e.stopImmediatePropagation();
            applyingForm.validate().settings.ignore = ':hidden, [data-validation="ignore"] input';
            alert('Проверьте заполнненость и корректность полей.');
            return false;
        }
    });

    /** События добавления и удаления полей специального права */
    $('#toggleSpecRights').change(function () {
        const block = $('#specRightsBlock');
        toggleDisplayBlock(block, $(this).is(':checked'));
        toggleIgnoreBlocks(block, $(this).is(':checked'));
    })

    $('#addSpecRightsInputButton').click(function () {
        cloneInputGroup(
            '.spec_rights_inputs',
            '#specRightsInputsGroups',
            'specRights'
        );
    })

    $('#removeSpecRightsInputButton').click(function () {
        removeInputGroup('#specRightsInputsGroups', '.spec_rights_inputs')
    })
    /** */

    /** События добавления и удаления полей приемущественного права */
    $('#togglePreemRights').change(function () {
        const block = $('#preemRightsBlock');
        toggleDisplayBlock(block, $(this).is(':checked'));
        toggleIgnoreBlocks(block, $(this).is(':checked'));
    })

    $('#addPreemRightsInputButton').click(function () {
        cloneInputGroup(
            '.preem_rights_input_group',
            '#preemRightsInputsGroups',
            'preemRights'
        );
    })

    $('#removePreemRightsInputButton').click(function () {
        removeInputGroup('#preemRightsInputsGroups', '.preem_rights_input_group')
    })

    /** События добавления и удаления полей индвидуальных достижений */
    $('#toggleIndividAchievs').change(function () {
        const block = $('#individAchievsBlock');
        toggleDisplayBlock(block, $(this).is(':checked'));
        toggleIgnoreBlocks(block, $(this).is(':checked'));
    })

    $('#addIndividAchievsInputButton').click(function () {
        cloneInputGroup(
            '.individ_achievs_input_group',
            '#individAchievsInputsGroups',
            'individAchievs'
        );
    })

    $('#removeIndividAchievsInputButton').click(function () {
        removeInputGroup('#individAchievsInputsGroups', '.individ_achievs_input_group')
    })
    /** */

    /** События добавления и удаления полей экзамена */
    $('#addExamInputsGroupButton').click(function () {
        cloneInputGroup(
            '.exam_inputs_group',
            '#examInputsGroups',
            'exams'
        );
    })

    $('#removeExamInputsGroupButton').click(function () {
        removeInputGroup('#examInputsGroups', '.exam_inputs_group', 3)
    })
    /** */

    /** Инициализация таблицы выбора направления */
    const contestTable = new ContestTable({
        rootElement: $('#rootContestTable'),
        specialityInput: $('#specialitySelect'),
        tableId: 'contestTable'
    });

    $('input[name="urov"]').change(function () {
        contestTable.resetValue();
    })

    $('#examInputsGroups select').change(function () {
        contestTable.resetValue();
    })

    window.testTable = contestTable;
    /** */

    /** Инициализация smartWizard */
    const smartWizard = $('#smartwizard');

    smartWizard.smartWizard({
        autoAdjustHeight: false,
        enableFinishButton: true,
        lang: { next: 'Далее', previous: 'Назад'},
        toolbarSettings: {
            toolbarExtraButtons: [
                $('<button></button>').text('Отправить заявление')
                    .addClass('btn btn-info')
            ]
        },
    })

    smartWizard.on("leaveStep", function(e, anchorObject, stepIndex, stepNum, stepDirection) {
        const stepHash = anchorObject[0].hash
        const validation = applyingForm.valid();
        if (stepDirection === 'backward') {
            return true;
        }
        if (stepHash === '#step-7' && $('.main_help_block').text()) {
            return false;
        }
        return (validation);
    });

    /** Инициализация 7 шага **/
    smartWizard.on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
        const stepHash = anchorObject[0].hash
        if (stepHash === '#step-7') {
            getSpecialityList(function (result) {
                $('.main_help_block').text((result.data.length) ? '' : 'Не найденно подходящих направлений');
                $('.contests_block').css('display', (result.data.length) ? 'block' : 'none');

                updateSelect('#specialitySelect', result.data, 'specialityCode', 'speciality')
            });
        }
    });

    // smartWizard.on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
    //     smartWizard.smartWizard("setOptions", {
    //         errorSteps: errorSteps
    //     });
    // });
});