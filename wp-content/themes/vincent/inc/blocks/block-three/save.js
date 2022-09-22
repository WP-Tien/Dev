import { RichText, useBlockProps } from '@wordpress/block-editor';

const Save = ( props ) => {
    const {
        attributes: { content, alignment },
    } = props;

	const blockProps = useBlockProps.save({
        className: `vincent-examples-align-${alignment}`
    });

	return (
		<RichText.Content
			{ ...blockProps }
			tagName="p"
			value={ content }
		/>
	);
};

export default Save;