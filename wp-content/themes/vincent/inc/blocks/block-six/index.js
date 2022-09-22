import { registerBlockType } from "@wordpress/blocks";

import json from './block.json';
import edit from './edit';
import save from './save';

const { name } = json;

registerBlockType( name, {
    edit, // Object shorthand property - same as writing: edit: edit, 
    save, // Object shorthand property - same as writing: save: save,
});