/** Сброс шагов при перезагрузке страницы */
window.location.hash = '';

/**
 *
 * @param options {{
 *     tableId: (string),
 *     resultTableId: (string),
 *     rootElement: (*|jQuery.fn.init|jQuery|HTMLElement),
 *     specialityInput: (*|jQuery.fn.init|jQuery|HTMLElement)
 * }}
 * @constructor
 */
const ContestTable = function (options) {

    /**
     * @type {string}
     */
    const tableId = (options.tableId) ? '#' + options.tableId : '#contestTable';

    /**
     * @type {string}
     */
    const resultTableId = (options.resultTableId)
        ? '#' + options.resultTableId
        : '#contestResultTable';

    /**
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    const rootElement = options.rootElement;

    /**
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    const specialityInput = options.specialityInput;

    /**
     * @type {*[]}
     */
    this.selectedContests = [];

    /**
     * @type {*[]}
     */
    this.contests = [];

    /**
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    this.table = null;

    /**
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    this.resultTable = null;

    const init = () => {
        this.table = ($(tableId).length) ? $(tableId) : createTable(rootElement, tableId);
        this.resultTable = ($(resultTableId).length)
            ? $(resultTableId)
            : createTable(
                rootElement,
                resultTableId,
                $(
                    '<caption></caption>',
                    {
                        text: 'Выбранные направления'
                    }
                )
            );
    }

    $(specialityInput).change(() => this.updateContests());

    const setContests = contests => this.contests = contests;

    /**
     * @param {*|jQuery.fn.init|jQuery|HTMLElement} rootElement
     * @param {string} tableId
     * @param {*|jQuery.fn.init|jQuery|HTMLElement} captionElement
     * @returns {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    const createTable = (rootElement, tableId, captionElement = null) => {
        const tableElement = $(
            '<table></table>',
            {
                class: 'table table-striped contest-table',
                id: tableId
            }
        );

        const tHead = $('<tr></tr>').append(
            $('<td></td>', {text: 'Направление подготовки', colspan: 3}),
            $('<td></td>', {text: 'Направленность (профиль)', colspan: 3}),
            $('<td></td>', {text: 'Факультет', colspan: 4})
        );

        if (captionElement) {
            rootElement.append(captionElement);
        }

        tableElement.append(tHead, $('<tbody></tbody>'));

        tableElement.css('display', 'none');

        return tableElement.appendTo(rootElement);
    }

    /**
     * @param {*|jQuery.fn.init|jQuery|HTMLElement} contestInput
     */
    const addSelectedContests = contestInput => {
        if (!contestInput.data().contest)
            return;

        const contest = contestInput.data().contest;

        const duplicateContests = this.selectedContests.some(selectedContest => {
            return _.isEqual(
                _.omit(selectedContest, ['checkedInputs']), contest
            );
        });

        if (duplicateContests) {
            alert('Данный конкурс уже есть среди выбранных, сначала удалите его.')
            return;
        }

        let cloneContest = _.clone(contest)
        cloneContest.checkedInputs = [];

        contestInput
            .find('input:checkbox:checked')
            .each(function (index, element) {
                cloneContest.checkedInputs.push($(element).attr('data-name'));
            });

        this.selectedContests.push(cloneContest);

        updateTableContests(true);
    };

    /**
     * @param {*|jQuery.fn.init|jQuery|HTMLElement} contestInput
     */
    const deleteSelectedContests = contestInput => {
        if (!contestInput.data().contest)
            return;

        const deletedContest = contestInput.data().contest;

        _.remove(this.selectedContests, function(contest) {
            return _.isEqual(contest, deletedContest);
        });

        updateTableContests(true);
    }

    /**
     * @param options{{
     *      contestPlan: (number),
     *      contestNoReception: (number),
     *      contestPlanInterval: (float),
     *      contestPriceForeign: (float)
     *      checkName: (string),
     *      checkValue: (boolean)
     *      typeText: (string),
     *      isResultTd: (boolean)
     * }}
     * @returns {{
     *      type: (*|jQuery.fn.init|jQuery|HTMLElement),
     *      value: (*|jQuery.fn.init|jQuery|HTMLElement)
     * }}
     */
    const generateContestTds = (options) => {
        if (!options.contestPlan && options.contestNoReception) {
            return {
                type: $('<td></td>'),
                value: $('<td></td>'),
            }
        }

        const text = getContestText(
            options.contestPlan,
            options.contestPlanInterval,
            options.contestPrice,
            options.contestPriceForeign
        );

        const checkbox = (options.isResultTd)
            ? $('<input/>', {
                type: 'checkbox', 
                name: options.checkName,
                checked: (options.checkValue) ? 'checked' : '',
                disabled: 'disabled'
              })
            : $('<input/>', {
                type: 'checkbox',
                'data-name': options.checkName
              });

        return {
            type: $('<td></td>', {text: options.typeText}),
            value: $('<td></td>', {html: text}).prepend(checkbox)
        }
    }

    /**
     * @param plan {number|string}
     * @param period {float|string}
     * @param price {float|string}
     * @param priceForeign {float|string}
     * @returns {string}
     */
    const getContestText = (plan, period, price, priceForeign) => {
        let text = '</br>';

        text += (plan) ? `Кол-во мест: ${plan}</br>` : '';
        text += (price) ? `Цена для граждан СНГ: ${price}</br>` : '';
        text += (priceForeign) ? `Цена для зарубежных граждан ${priceForeign}</br>` : '';
        text += (period) ? `Кол-во лет обучения: ${period}</br>` : '';

        return text;
    }

    /**
     * Функция генерирует новый tbody и заменяет старый
     * @param resultFlag {boolean}
     */
    const updateTableContests = (resultFlag = false) => {
        const tbody = $('<tbody></tbody>');

        const table = (resultFlag)
            ? this.resultTable
            : this.table

        const contests = (resultFlag)
            ? this.selectedContests
            : this.contests;

        if (!contests) {
            table.find('tbody').first().replaceWith(tbody);
            table.css('display', 'none');
        }

        contests.forEach(contest => {

            const trHeadValue = $('<tr></tr>');
            trHeadValue.append($('<td></td>', {text: contest.speciality, colspan: 3}));
            trHeadValue.append($('<td></td>', {text: contest.specialization, colspan: 3}));
            trHeadValue.append($('<td></td>', {text: contest.faculty, colspan: 4}));

            const trType = $('<tr></tr>');
            const trValue = $('<tr></tr>').data('contest', contest);

            /** Вывод коммерческих конкурсов */
            const internalCommerce = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planInternalCommerce,
                contestNoReception: contest.noReceptionInternal,
                contestPlanInterval: contest.planInternalCommerce,
                contestPrice: contest.priceInternal,
                contestPriceForeign: contest.priceInternalForeign,
                checkName: 'planInternalCommerce',
                checkValue: true,
                typeText: 'Комм. Очная'
            });

            const externalCommerce = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planExternalCommerce,
                contestNoReception: contest.noReceptionExternal,
                contestPlanInterval: contest.periodExternalYears,
                contestPrice: contest.priceExternal,
                contestPriceForeign: null,
                checkName: 'planExternalCommerce',
                checkValue: true,
                typeText: 'Комм. Заочная'
            });


            const ieCommerce = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planIECommerce,
                contestNoReception: contest.noReceptionIE,
                contestPlanInterval: contest.periodIEYears,
                contestPrice: contest.priceIE,
                contestPriceForeign: contest.priceIEForeign,
                checkName: 'planIECommerce',
                checkValue: true,
                typeText: 'Комм. Очно-заочная'
            });

            /** Целевой конкурс */
            const internalTarget = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planInternalTarget,
                contestNoReception: contest.noReceptionInternal,
                contestPlanInterval: contest.periodInternalTarget,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: 'planInternalTarget',
                checkValue: true,
                typeText: 'Целевое очное'
            });

            const externalTarget = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planExternalTarget,
                contestNoReception: contest.noReceptionExternal,
                contestPlanInterval: contest.periodExternalYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: 'planExternalTarget',
                checkValue: true,
                typeText: 'Целевое заочное'
            });

            const ieTarget = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planIETarget,
                contestNoReception: contest.noReceptionIE,
                contestPlanInterval: contest.periodIEYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: 'planIETarget',
                checkValue: true,
                typeText: 'Целевое очно-заочное'
            });

            /** Общий конкурс */
            const internal = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planInternal,
                contestNoReception: contest.noReceptionInternal,
                contestPlanInterval: contest.periodInternalYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: 'planInternal',
                checkValue: true,
                typeText: 'Общее очное'
            });

            const external = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planExternal,
                contestNoReception: contest.noReceptionExternal,
                contestPlanInterval: contest.periodExternalYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: 'planExternal',
                checkValue: true,
                typeText: 'Общее заочное'
            });

            const ie = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planIE,
                contestNoReception: contest.noReceptionIE,
                contestPlanInterval: contest.periodIEYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: 'planIE',
                checkValue: true,
                typeText: 'Общее очно-заочное'
            });

            const button = $(
                '<button></button>',
                {
                    class: 'btn btn-primary btn-sm',
                    text: (resultFlag) ? 'Удалить' : 'Добавить',
                    type: 'button'
                }
            );

            button.click(function () {
                if (resultFlag) {
                    deleteSelectedContests($(this).parent().parent());
                } else {
                    addSelectedContests($(this).parent().parent());
                }
            })

            trValue.append(
                internalCommerce.value,
                externalCommerce.value,
                ieCommerce.value,
                internalTarget.value,
                externalTarget.value,
                ieTarget.value,
                internal.value,
                external.value,
                ie.value,
                $('<td></td>').append(button)
            );

            trType.append(
                internalCommerce.type,
                externalCommerce.type,
                ieCommerce.type,
                internalTarget.type,
                externalTarget.type,
                ieTarget.type,
                internal.type,
                external.type,
                ie.type,
                $('<td></td>', {text: 'Добавить'})
            );

            tbody.append(
                trHeadValue,
                trType,
                trValue,
                $('<tr></tr>')
            );
        });

        table.find('tbody').first().replaceWith(tbody);
        table.css('display', 'table');
    }

    this.updateContests = () => {
        const formData = $('#applyingForm').serializeArray();
        formData.push({
            name: 'speciality[code]',
            value: specialityInput.val()
        })
        formData.push({
            name: 'speciality[name]',
            value: specialityInput.text()
        })
        $.ajax({
            async: false,
            url: '/apiV1/contest/available_by_leaver_and_speciality/',
            method: 'post',
            dataType: 'html',
            data: formData,
            success: function(result){
                result = JSON.parse(result);
                if (result.data) {
                    setContests(result.data);
                    updateTableContests()
                }
                console.log(result);
            }
        });
    };

    this.goToStep = () => {
        $('#urovCheck1').prop('checked', true);
        $('[name="exams[0][examId]"] option[value=2]').prop('selected', true);
        $('[name="exams[1][examId]"] option[value=1]').prop('selected', true);
        $('[name="exams[2][examId]"] option[value=9]').prop('selected', true);
        $('#smartwizard').smartWizard("goToStep", 6);
        this.updateContests();
    }

    this.test = () => {
        console.log(specialityInput.val(), specialityInput.text())
    };

    init();
}

const cloneInputGroup = (groupSelector, containerSelector, autoIncArrayInputs = false) => {
    const cloneGroup = $(groupSelector).first().clone();
    const groupsCount = $(containerSelector).find(groupSelector).length;

    if (autoIncArrayInputs === true) {
        cloneGroup.find('input, select').each(function (){
            console.log($(this).attr('name').replace(/.+?\[[^\]]*\]/, 'exams['+(groupsCount)+']'));
            $(this).attr('name', $(this).attr('name').replace(/.+?\[[^\]]*\]/, 'exams['+(groupsCount)+']'));
        })
    }

    cloneGroup.find('input').val('');
    cloneGroup.appendTo(containerSelector);
}

const removeInputGroup = (containerSelector, groupSelector, minCount = 1) => {
    const inputGroups = $(containerSelector).find(groupSelector);
    if (inputGroups.length > minCount) {
        inputGroups.last().remove();
    }
}

const updateSelect = (selector, data, indexKey, valueKey) => {
    const select = $(selector);
    select.empty();
    if (!data.length)
        return false;
    data.forEach(item => {
        select.append($("<option></option>", {value: item[indexKey], text: item[valueKey]}));
    });
    return true;
}

window.getFromData = () => {
    const fd = new FormData(document.forms.applyingForm);
    for(let [name, value] of fd) {
        console.log(`${name} = ${value}`);
    }
};

window.getSpecialityList = (successCallback) => {
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
            else
                console.log(result);
        }
    });
};

window.updateTest = () => {
    window.getSpecialityList(function (result) {
        updateSelect('#specialitySelect', result.data, 'specialityCode', 'speciality')
    });
};

$(document).ready(function(){
    /** События добавления и удаления полей специального права */
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

    /** События добавления и удаления полей приемущественного права */
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

    /** События добавления и удаления полей индвидуальных достижений */
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

    /** События добавления и удаления полей экзамена */
    $('#addExamInputsGroupButton').click(function () {
        cloneInputGroup('.exam_inputs_group', '#examInputsGroups', true)
    })

    $('#removeExamInputsGroupButton').click(function () {
        removeInputGroup('#examInputsGroups', '.exam_inputs_group', 3)
    })

    /** Инициализация таблицы выбора направления */
    const contestTable = new ContestTable({
        rootElement: $('#rootContestTable'),
        specialityInput: $('#specialitySelect'),
        tableId: 'contestTable'
    });
    window.testTable = contestTable;

    /** Инициализация smartWizard */
    let errorSteps = [];
    const smartWizard = $('#smartwizard');

    smartWizard.smartWizard({
        autoAdjustHeight: false,
        enableFinishButton: true,
        lang: { next: 'Далее', previous: 'Назад', finish: 'Отправить заявление'},
        toolbarSettings: {
            toolbarExtraButtons: [
                $('<button></button>').text('Finish')
                    .addClass('btn btn-info')
                    .on('click', function(){
                        document.forms.applyingForm.submit();
                    })
            ]
        },
    })

    /** Инициализация 7 шага **/
    smartWizard.on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
        const stepHash = anchorObject[0].hash
        if (stepHash === '#step-7') {
            window.getSpecialityList(function (result) {
                const feedbackText = (result.data.length) ? '' : 'Не найденно подходящих направлений';
                const contestsBlockDisplay = (result.data.length) ? 'block' : 'none';
                $('.main_help_block').text(feedbackText);
                $('.contests_block').css('display', contestsBlockDisplay);
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