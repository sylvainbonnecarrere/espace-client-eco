import { mount } from '@vue/test-utils';
import { describe, it, expect } from 'vitest';
import InputError from '@/components/InputError.vue';

describe('InputError.vue', () => {
    it('does not display anything when no message is provided', () => {
        const wrapper = mount(InputError);
        expect(wrapper.find('div').isVisible()).toBe(false);
    });

    it('displays the error message when provided via props', async () => {
        const message = 'Invalid fields detected';
        const wrapper = mount(InputError, {
            props: { message }
        });

        // isVisible requires testing DOM layout. For simple display check, text content is fine:
        expect(wrapper.text()).toContain(message);
    });
});
