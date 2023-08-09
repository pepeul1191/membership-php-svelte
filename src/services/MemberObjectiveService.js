import axios from 'axios';
import { CSRF } from '../stores/csrf.js';

export const getObjectives = (memberId) => {
  return new Promise((resolve, reject) => {
    axios.get('admin/member/objective', {
      params: {
        'member_id': memberId
      },
      headers:{
        [CSRF.key]: CSRF.value,
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Miembro no encontrado')
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

export const setObjectives = (params) => {
  return new Promise((resolve, reject) => {
    axios.post('admin/member/objective', JSON.stringify(params), {
      headers: {
        'Content-Type': 'application/json',
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Miembro a asociar no existe en el servidor')
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