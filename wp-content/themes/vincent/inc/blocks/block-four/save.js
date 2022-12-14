import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps } from '@wordpress/block-editor';

const Save = ( props ) => {
    const {
        attributes: { title, mediaID, mediaURL, ingredients, instructions }
    } = props;

    const blockProps = useBlockProps.save();

    return(
        <div { ...blockProps } >
            <RichText.Content tagName="h2" value={ title } />            

            { mediaURL && (
                <img 
                    className="recipe-image"
                    src={ mediaURL } 
                    alt={ __( 'Recipe Image', 'vincent' ) } 
                />
            ) }

            <h3>{ __( 'Ingredients', 'vincent' ) }</h3>
            <RichText.Content
                tagName="ul"
                className="ingredients"
                value={ ingredients }
            />

            <h3>{ __( 'Instructions', 'vincent' ) }</h3>
            <RichText.Content 
                tagName="div"
                className="steps"
                value={ instructions }
            />
        </div>
    )
};

export default Save;