// const { registerBlockType } = wp.blocks;
// import registerBlockType from wp.blocks;

wp.blocks.registerBlockType( 'example/custom-block',{
    // built-in attributes
    title: 'Example Block',
    icon: 'hammer',
    category: 'design',
    description: 'Block to generate a custom Call to Action',

    // custom attributes
    attributes: {
        companyName: { type: 'string' },
        companyPhone: { type: 'string' },
        companyAddress: { type: 'string' },
        companyAddress2: { type: 'string' },
        companyCity: { type: 'string' },
        companyState: { type: 'string' },
        companyZip: { type: 'string' }
    },

    // custom functions

    // built-in functions
    edit: function( props ){

        function updateCompanyName(e){ props.setAttributes({companyName: e.target.value }) }
        function updateCompanyPhone(e){ props.setAttributes({companyPhone: e.target.value }) }
        function updateCompanyAddress(e){ props.setAttributes({companyAddress: e.target.value }) }
        function updateCompanyAddress2(e){ props.setAttributes({companyAddress2: e.target.value }) }
        function updateCompanyCity(e){ props.setAttributes({companyCity: e.target.value }) }
        function updateCompanyState(e){ props.setAttributes({companyState: e.target.value }) }
        function updateCompanyZip(e){ props.setAttributes({companyZip: e.target.value }) }

        return React.createElement("div", null,
            React.createElement("label", null, "Company Name"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyName,
                placeholder: "Company name",
                onChange: updateCompanyName
            }),
            React.createElement("br"),
            React.createElement("label", null, "Company Phone"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyPhone,
                placeholder: "Company phone",
                onChange: updateCompanyPhone
            }),
            React.createElement("br"),
            React.createElement("label", null, "Company Address"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyAddress,
                placeholder: "Company address",
                onChange: updateCompanyAddress
            }),
            React.createElement("br"),
            React.createElement("label", null, "Company Address 2"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyAddress2,
                placeholder: "Company address 2",
                onChange: updateCompanyAddress2
            }),
            React.createElement("br"),
            React.createElement("label", null, "Company city"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyCity,
                placeholder: "Company city",
                onChange: updateCompanyCity
            }),
            React.createElement("br"),
            React.createElement("label", null, "Company state"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyState,
                placeholder: "Company state",
                onChange: updateCompanyState
            }),
            React.createElement("br"),
            React.createElement("label", null, "Company zipcode"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.companyZip,
                placeholder: "Company zipcode",
                onChange: updateCompanyZip
            }),
        );
    }, 
    save: function( props ){
        return React.createElement("div", null,
            React.createElement("h3", null, 
                props.attributes.companyName            
            ),
            React.createElement("br"),
            React.createElement("div", null,
                props.attributes.companyPhone
            ),
            React.createElement("br"),
            React.createElement("span", null,
                props.attributes.companyAddress
            ),
            React.createElement("br"),
            React.createElement("span", null,
                props.attributes.companyAddress2
            ),
            React.createElement("br"),
            React.createElement("div", null, 
                React.createElement("span", null, props.attributes.companyCity),
                React.createElement("span", null, props.attributes.companyState),
                React.createElement("span", null, props.attributes.companyZip)
            )
        );
    }
});