import {
    RichText,
    AlignmentToolbar,
    BlockControls,
    useBlockProps       
} from '@wordpress/block-editor';

import './editor.scss';

const Edit = ( props ) => {
    const {
        attributes: { content, alignment },
        setAttributes,
    } = props;

    const blockProps = useBlockProps({
        className: `vincent-examples-align-${alignment}`
    });

    const onChangeContent = ( newContent ) => {
        setAttributes( { content: newContent } );
    }

    const onChangeAlignment = ( newAlignment ) => {
        setAttributes( { alignment: newAlignment === undefined ? 'none' : newAlignment } );
    }

    return (
        <div { ...blockProps } >
            {
                <BlockControls>
                    <AlignmentToolbar 
                        value={ alignment }
                        onChange={ onChangeAlignment }
                    />
                </BlockControls>
            }
            <RichText
                style={ { textAlign: alignment } }
                tagName="p"
                onChange={ onChangeContent }
                value={ content }
            />
        </div>
    )
};

export default Edit;