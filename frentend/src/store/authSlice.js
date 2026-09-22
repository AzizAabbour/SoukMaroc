import { createSlice } from '@reduxjs/toolkit';

const initialState = {
  user:  JSON.parse(localStorage.getItem('sm_user'))  || null,
  token: localStorage.getItem('sm_token') || null,
};

const authSlice = createSlice({
  name: 'auth',
  initialState,
  reducers: {
    setCredentials(state, { payload }) {
      state.user  = payload.user;
      state.token = payload.token;
      localStorage.setItem('sm_user',  JSON.stringify(payload.user));
      localStorage.setItem('sm_token', payload.token);
    },
    logout(state) {
      state.user  = null;
      state.token = null;
      localStorage.removeItem('sm_user');
      localStorage.removeItem('sm_token');
    },
  },
});

export const { setCredentials, logout } = authSlice.actions;
export default authSlice.reducer;
