import { __ } from '@wordpress/i18n';
import { RichText, MediaUpload, useBlockProps } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

const Edit = ( props ) => {
    const {
        attributes: { title, mediaID, mediaURL, ingredients, instructions },
        setAttributes
    } = props;

    const blockProps = useBlockProps();

    const onChangeTitle = ( title ) => {
        setAttributes( { title } );
    };

    const onSelectImage = ( media ) => {
        setAttributes( {
            mediaURL: media.url,
            mediaID: media.id
        } );
    }

    const onChangeIngredients = ( ingredients ) => {
        setAttributes( { ingredients } );
    }

    const onChangeInstructions = ( instructions ) => {
        setAttributes( { instructions } );
    };
    
    return (
        <div { ...blockProps } >
            <RichText 
                tagName="h2"
                placeholder={ __(
                    'Write Recipe title...',
                    'vincent'
                ) }
                value={ title }
                onChange={ onChangeTitle }
            />
            <div className="recipe-image">
                <MediaUpload
                    onSelect={ onSelectImage }
                    allowedTypes="image"
                    value={ mediaID }
                    render={ ( { open } ) => (
                        <Button
                            className={  
                                mediaID ? 'image-button' : 'button button-large'
                            }
                            onClick={ open }
                        >
                            { !mediaID ? (
                                __( 'Upload Image', 'vincent' )
                            ) : (
                                <img 
                                    src={ mediaURL } 
                                    alt={ __(
                                        'Upload Recipe Image',
                                        'vincent'
                                    )} 
                                />
                            ) }
                        </Button>
                    ) }
                />
            </div>
            <h3>{ __( 'Ingredients', 'vincent' ) }</h3>
            <RichText 
                tagName="ul"
                multiline="li"
                placeholder={ __(
                    'Write a list of ingredients...',
                    'vincent'
                ) }
                value={ingredients}
                onChange={ onChangeIngredients }
            />
            <h3>{ __( 'Instructions', 'vincent' ) }</h3>
            <RichText
                tagName="div"
                multiline="p"
                className="steps"
                placeholder={ __(
                    'Write the instruction...',
                    'vincent'
                ) }
                value={ instructions }
                onChange={ onChangeInstructions }
            />
        </div>
    );
}

export default Edit;