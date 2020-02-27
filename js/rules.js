var addRuleType = BBLogic.api.addRuleType
var __ = BBLogic.i18n.__

// Paged
addRuleType( 'bb-extra-conditional-logic/paged', {
    label: __( 'Archive Page' ),
    category: 'archive',
    form: {
        operator: {
            type: 'operator',
            operators: [
                'equals',
                'does_not_equal',
                'is_less_than',
                'is_greater_than',
            ],
        },
        value: {
            type: 'number',
            defaultValue: '0',
        },
    },
});
