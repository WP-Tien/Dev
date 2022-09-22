import { registerBlockType } from '@wordpress/blocks';

import edit from './edit';
import save from './save';
import json from './block.json';

const { name, ...setings } = json;

registerBlockType( name, {
    ...setings,

    edit,
    save,
});