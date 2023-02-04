import { message } from "laravel-mix/src/Log";
import { createStore } from "vuex";

const store = createStore({
    state(){
        return{
            authenticated:false,
            user:null
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
        async signIn( {commit}, payload){
            try{
            await axios.get('/sanctum/csrf-cookie');
                const res = await axios.post('/api/authenticate',payload);
                if( res.data.status_code != 200){
                    throw res.message;
                }
                console.log(res);
                axios.get('/api/user').then(res=>{
                    commit('setUser',res.data);
                    commit('setAuthenticated',true)
                }).catch(()=>{
                    commit('setUser',null);
                    commit('setAuthenticated',false)
                });
            }catch(e){
                throw 'User can not be authenticaeted';
            }
            
        }
    }
});

export default store;