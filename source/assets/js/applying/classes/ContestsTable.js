/**
 * @param options {{rootElement: (*|jQuery.fn.init|jQuery|HTMLElement), tableId: string, specialityInput: (*|jQuery.fn.init|jQuery|HTMLElement)}}
 * @constructor
 */
const ContestTable = function (options) {

    /**
     * id таблицы
     *
     * @type {string}
     */
    const tableId = (options.tableId) ? '#' + options.tableId : '#contestTable';

    /**
     * id результирующей таблицы
     *
     * @type {string}
     */
    const resultTableId = (options.resultTableId)
        ? '#' + options.resultTableId
        : '#contestResultTable';

    /**
     * id родительского элемента
     *
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    const rootElement = options.rootElement;

    /**
     * id select'а в котором хранится информация о выбранном направлении
     *
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    const specialityInput = options.specialityInput;

    /**
     * id блока для полей файлов с документами целевых конкуров
     *
     * @type {string}
     */
    const targetDocBlockId = (options.targetDocBlockId)
        ? '#' + options.targetDocBlockId
        : '#targetDocBlock';

    /**
     * Enum для хранения имен конкурсов
     *
     * @type {{
     *      internal: string,
     *      external: string,
     *      ieCommerce: string,
     *      ieTarget: string,
     *      internalCommerce: string,
     *      externalCommerce: string,
     *      externalTarget: string,
     *      ie: string,
     *      internalTarget: string
     *  }}
     */
    const contestsPlanEnum = {
        internalCommerce: 'planInternalCommerce',
        externalCommerce: 'planExternalCommerce',
        ieCommerce: 'planIECommerce',
        internalTarget: 'planInternalTarget',
        externalTarget: 'planExternalTarget',
        ieTarget: 'planIETarget',
        internal: 'planInternal',
        external: 'planExternal',
        ie: 'planIE'
    };

    /**
     * Выбранные конкурсы
     *
     * @type {*[]}
     */
    this.selectedContests = [];

    /**
     * Все конкурсы
     *
     * @type {*[]}
     */
    this.contests = [];

    /**
     * Элемент таблицы
     *
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    this.table = null;

    /**
     * Элемент результирующей таблицы
     *
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    this.resultTable = null;

    /**
     * Элемент блока документов целевых конкурсов
     *
     * @type {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    this.targetDocBlock = null;

    /**
     * Функция для инициализации объекта
     */
    const init = () => {
        this.table = ($(tableId).length)
            ? $(tableId)
            : createTable(
                rootElement,
                tableId,
                $(
                    '<h2></h2>',
                    {
                        class: 'text-center',
                        text: 'Выбор направления'
                    }
                )
            );

        this.resultTable = ($(resultTableId).length)
            ? $(resultTableId)
            : createTable(
                rootElement,
                resultTableId,
                $(
                    '<h2></h2>',
                    {
                        class: 'text-center',
                        text: 'Выбранные направления'
                    }
                )
            );

        this.targetDocBlock = ($(targetDocBlockId).length)
            ? $(targetDocBlockId)
            : createTargetDocBlock(rootElement, targetDocBlockId)
    }

    /**
     * Создание блока полей документов целевых конкурсов
     *
     * @param rootElement
     * @param targetDocBlockId
     * @returns {*|jQuery}
     */
    const createTargetDocBlock = (rootElement, targetDocBlockId) => $(
        '<div></div>',
        {
            id: targetDocBlockId,
            class: 'form-group'
        }
    ).appendTo(rootElement);

    $(specialityInput).change(() => this.updateContests());

    /**
     * Сеттер для конкурсов
     *
     * @param {array} contests
     * @return {*}
     */
    const setContests = contests => this.contests = contests;

    /**
     * Функция для создания каркаса таблицы
     *
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

        return tableElement.appendTo(rootElement);
    }

    /**
     * Функция проверяет превышает ли кол-во выбранных конкурсов 3
     *
     * @param codeOKCO
     * @returns {boolean}
     */
    const checkOKCOLimit = (codeOKCO) => {
        if (!this.selectedContests.length)
            return false;

        let okcoCountList = [];

        this.selectedContests.forEach(selectedContest => {
            if (okcoCountList[selectedContest.codeOKCO])
                okcoCountList[selectedContest.codeOKCO]++;
            else
                okcoCountList[selectedContest.codeOKCO] = 1;
        })

        return okcoCountList[codeOKCO] === 3;
    }

    /**
     * Функция добавляет конкурс в выбранные
     *
     * @param {*|jQuery.fn.init|jQuery|HTMLElement} contestInput
     */
    const addSelectedContests = contestInput => {
        if (!contestInput.data().contest)
            return;

        const contest = contestInput.data().contest;

        if (!contestInput.find('input:checkbox:checked').length) {
            alert('Выберите хотя бы один конкурс.')
            return;
        }

        const isDuplicateContests = this.selectedContests.some(selectedContest => {
            return _.isEqual(
                _.omit(selectedContest, ['checkedInputs']), contest
            );
        });

        if (isDuplicateContests) {
            alert('Данный конкурс уже есть среди выбранных, сначала удалите его.')
            return;
        }

        if (checkOKCOLimit(contest.codeOKCO)) {
            alert('Выбранно максимальное количество специальностей из данного направления.');
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
     * Функция удаляет выбранные конкурсы
     *
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
     * Функция для генерации td в таблице
     *
     * @param options{{
     *      contestPlan: (number),
     *      contestNoReception: (number),
     *      contestPlanInterval: (float),
     *      contestPrice: (float),
     *      contestPriceForeign: (float),
     *      checkName: (string),
     *      checkValue: (boolean),
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
                checked: (options.checkValue) ? 'checked' : null,
                value: 1,
                readonly: 'readonly'
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
     * Функция генерирует текст для ячейки конкурса в таблице
     *
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
     * Функция проверяет, выбранн ли определенный конкурс
     *
     * @param {string} plan
     * @param {array} selectedContests
     * @return {boolean}
     */
    const isCheckedContest = (plan, selectedContests) => selectedContests.indexOf(plan) !== -1;

    /**
     * Функция генерирует имя для полей выбранного направления
     *
     * @param {string} name
     * @param {string|number} contestCount
     * @return {string}
     */
    const generateResultInputName = (name, contestCount) => `specials[${contestCount}][${name}]`;

    /**
     * Сброс выбраных полей ввода
     */
    this.resetValue = () => {
        this.selectedContests = [];
        updateTableContests(true);
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

        const targetPlanList = [
            contestsPlanEnum.internalTarget,
            contestsPlanEnum.externalTarget,
            contestsPlanEnum.ieTarget
        ];

        if (!contests) {
            table.find('tbody').first().replaceWith(tbody);
            table.css('display', 'none');
        }

        const targetInputs = [];

        contests.forEach((contest, contestIndex) => {

            const trHeadValue = $('<tr></tr>');
            trHeadValue.append($('<td></td>', {text: contest.speciality, colspan: 3}));
            trHeadValue.append($('<td></td>', {text: contest.specialization, colspan: 3}));
            trHeadValue.append($('<td></td>', {text: contest.faculty, colspan: 4}));

            const trType = $('<tr></tr>');
            const trValue = $('<tr></tr>').data('contest', contest);

            if (resultFlag)
                trValue.append($('<input>', {
                    type: 'hidden',
                    name: generateResultInputName(
                        'idContest',
                        contestIndex
                    ),
                    value: contest.id
                }));

            /** Вывод коммерческих конкурсов */
            const internalCommerce = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planInternalCommerce,
                contestNoReception: contest.noReceptionInternal,
                contestPlanInterval: contest.planInternalCommerce,
                contestPrice: contest.priceInternal,
                contestPriceForeign: contest.priceInternalForeign,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.internalCommerce,
                    contestIndex
                ) : contestsPlanEnum.internalCommerce,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.internalCommerce,
                    contest.checkedInputs
                ) : false,
                typeText: 'Комм. Очная'
            });

            const externalCommerce = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planExternalCommerce,
                contestNoReception: contest.noReceptionExternal,
                contestPlanInterval: contest.periodExternalYears,
                contestPrice: contest.priceExternal,
                contestPriceForeign: null,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.externalCommerce,
                    contestIndex
                ) : contestsPlanEnum.externalCommerce,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.externalCommerce,
                    contest.checkedInputs
                ) : false,
                typeText: 'Комм. Заочная'
            });


            const ieCommerce = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planIECommerce,
                contestNoReception: contest.noReceptionIE,
                contestPlanInterval: contest.periodIEYears,
                contestPrice: contest.priceIE,
                contestPriceForeign: contest.priceIEForeign,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.ieCommerce,
                    contestIndex
                ) : contestsPlanEnum.ieCommerce,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.ieCommerce,
                    contest.checkedInputs
                ) : false,
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
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.internalTarget,
                    contestIndex
                ) : contestsPlanEnum.internalTarget,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.internalTarget,
                    contest.checkedInputs
                ) : false,
                typeText: 'Целевое очное'
            });

            const externalTarget = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planExternalTarget,
                contestNoReception: contest.noReceptionExternal,
                contestPlanInterval: contest.periodExternalYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.externalTarget,
                    contestIndex
                ) : contestsPlanEnum.externalTarget,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.externalTarget,
                    contest.checkedInputs
                ) : false,
                typeText: 'Целевое заочное'
            });

            const ieTarget = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planIETarget,
                contestNoReception: contest.noReceptionIE,
                contestPlanInterval: contest.periodIEYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.ieTarget,
                    contestIndex
                ) : contestsPlanEnum.ieTarget,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.ieTarget,
                    contest.checkedInputs
                ) : false,
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
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.internal,
                    contestIndex
                ) : contestsPlanEnum.internal,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.internal,
                    contest.checkedInputs
                ) : false,
                typeText: 'Общее очное'
            });

            const external = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planExternal,
                contestNoReception: contest.noReceptionExternal,
                contestPlanInterval: contest.periodExternalYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.external,
                    contestIndex
                ) : contestsPlanEnum.external,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.external,
                    contest.checkedInputs
                ) : false,
                typeText: 'Общее заочное'
            });

            const ie = generateContestTds({
                isResultTd : resultFlag,
                contestPlan: contest.planIE,
                contestNoReception: contest.noReceptionIE,
                contestPlanInterval: contest.periodIEYears,
                contestPrice: null,
                contestPriceForeign: null,
                checkName: (resultFlag) ? generateResultInputName(
                    contestsPlanEnum.ie,
                    contestIndex
                ) : contestsPlanEnum.ie,
                checkValue: (resultFlag) ? isCheckedContest(
                    contestsPlanEnum.ie,
                    contest.checkedInputs
                ) : false,
                typeText: 'Общее очно-заочное'
            });

            const button = $(
                '<button></button>',
                {
                    class: 'btn btn-sm' + (resultFlag)
                        ? 'btn-danger' : 'btn-primary',
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
                trValue
            );

            if (resultFlag && contest.checkedInputs.length) {
                targetInputs.push(generateResultInputName('targetDocFile', contestIndex));
            }
        });

        if (resultFlag)
            updateTargetDocBlock(targetInputs);

        table.find('tbody').first().replaceWith(tbody);
    }

    /**
     * Функция обновляет инпуты для файлов документов целевого обучения
     *
     * @param targetInputsNames {string[]}
     */
    const updateTargetDocBlock = (targetInputsNames = []) => {
        this.targetDocBlock.empty();

        if (targetInputsNames.length) {
            targetInputsNames.forEach(inputName => {
                const docLabel =  $(
                    '<label></label>',
                    {text: 'Скан документа для целевого направления:'}
                );
                const docInput = $(
                    '<input>',
                    {
                        type: 'file',
                        class: 'form-control-file',
                        name: inputName
                    }
                );

                this.targetDocBlock.append(docLabel, docInput);
            });
        }
    };

    /**
     * Функция делает ajax запрос для получения данныхданных о доступных конкурсах
     */
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
            }
        });
    };

    /**
     * @deprecated
     * Функция для отладки объекта (позволяет быстро перейти к таблице конкурсов).
     */
    this.goToStep = () => {
        $('#urovCheck1').prop('checked', true);
        $('[name="exams[0][examId]"] option[value="2"]').prop('selected', true);
        $('[name="exams[1][examId]"] option[value="1"]').prop('selected', true);
        $('[name="exams[2][examId]"] option[value="9"]').prop('selected', true);
        $('#smartwizard').smartWizard("goToStep", 6);
    }

    init();
}