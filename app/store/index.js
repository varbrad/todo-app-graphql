import Vuex from 'vuex'

const createStore = () => {
  return new Vuex.Store({
    state: {
      viewer: null, // The user viewer object
      // Whether an auth attempt has been made
      // We have no way of knowing whether the user is logged-in or not
      // as the session cookie is a HttpOnly cookie and not accesible from JS
      authAttempted: false
    },
    mutations: {
      authAttempt(state, viewer) {
        state.authAttempted = true;
        if (viewer !== null) state.viewer = viewer;
      },
      resetAuth(state) {
        state.viewer = null;
      }
    }
  })
}

export default createStore
