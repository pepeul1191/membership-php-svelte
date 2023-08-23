import axios from 'axios';
import { CSRF } from '../stores/csrf.js';

export const getMemberUser = (memberId) => {
  return new Promise((resolve, reject) => {
    axios.get(`access/member/${memberId}/user`, {
      params: {},
      headers:{
        [CSRF.key]: CSRF.value,
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      reject(error);
    })
    .then(function () {
      // todo?
    });
  });
}

export const updateMemberUser = (params ) => {
  return new Promise((resolve, reject) => {
    axios.post('access/member/update', JSON.stringify(params), {
      headers: {
        'Content-Type': 'application/json',
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Miembro a editar no existe en el servidor')
      }else{
        console.error(error.response.data);
      }
      reject(error.response);
    })
    .then(function () {
      // todo?
    });
  });
}

export const resetPasswordMemberUser = (params ) => {
  return new Promise((resolve, reject) => {
    axios.post('access/member/reset_password', JSON.stringify(params), {
      headers: {
        'Content-Type': 'application/json',
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Usuario para resetear contraseña no existe en el servidor')
      }else{
        console.error(error.response.data);
      }
      reject(error.response);
    })
    .then(function () {
      // todo?
    });
  });
}