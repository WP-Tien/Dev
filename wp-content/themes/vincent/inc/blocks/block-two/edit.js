import { useBlockProps, RichText } from '@wordpress/block-editor';

import './editor.scss';

const Edit = ( props ) => {
    const { 
        attributes: { content }, 
        setAttributes, 
    } = props;

    const blockProps = useBlockProps();
    
    const onChangeContent = ( newContent ) => {
        setAttributes( { content: newContent } );
    };

    return (
        <RichText
            { ...blockProps }
            tagName="p"
            onChange={ onChangeContent }
            value={ content }
        />
    );  
}

export default Edit;