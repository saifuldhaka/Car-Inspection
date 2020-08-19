
import '@fortawesome/fontawesome-free/css/all.css' 
import Vue from 'vue';
import Vuetify from 'vuetify/lib';

import { Ripple } from 'vuetify/lib/directives';


Vue.use(Vuetify, {
  directives: {
    Ripple
  }
})

export default new Vuetify({
  icons: {
    // iconfont: 'mdi',
    iconfont: 'fa',
  },
  theme: {
    themes: {
      light: {
        primary: '#fecf3d',
        secondary: '#9b9b9b',
        accent: '#8c9eff',
        error: '#b71c1c',
      },
    },
  },
});

