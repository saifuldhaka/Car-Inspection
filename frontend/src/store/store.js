import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

const state = {
    userLogin : false,
    baseUrl : 'http://127.0.0.1:8000'
}

const getters = {
    getBaseUrl: state => {
         return state.baseUrl;
    }
}

const mutations = {
}

const actions = {
}

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    plugins: [createPersistedState({

      })],

});
