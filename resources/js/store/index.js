import { createStore } from "vuex";
//import Vuex from "vuex";

const store = createStore({
//const store = new Vuex.Store({
    state(){
        return{
            authenticated:false,
            user:null,
            company:'Asiancoder'
        }
    },
    getters:{
        authenticated(state){
            return state.authenticated;
        },
        user(state){
            return state.user;
        }
    },
    mutations:{
        setUser(state, payload){
            state.user= payload;
        },
        setAuthenticated(state, payload){
            state.authenticated = payload;
        }
    },
    actions:{
        async signIn( {dispatch}, payload){
            try{
            await axios.get('/sanctum/csrf-cookie');
                const res = await axios.post('/api/authenticate',payload);
                if( res.data.status_code != 200){
                    throw res.message;
                }
                localStorage.setItem('token',res.data.access_token);
                axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
                return dispatch('getUser');
            }catch(e){
                throw 'User can not be authenticaeted';
            }
            
        },

        async getUser({commit}){
            await axios.get('/api/user').then(res=>{
                    commit('setUser',res.data);
                    commit('setAuthenticated',true);
                }).catch(()=>{
                    commit('setUser',null);
                    commit('setAuthenticated',false)
                });
        },

        async logout({commit}){
            await axios.get('/api/logout').then( res=>{
                commit('setUser',null);
                commit('setAuthenticated',false);
            }).catch(()=>{
                commit('setUser',null);
                commit('setAuthenticated',false)
            });
        }
    }
});

export default store;