import axios from 'axios';
import { CSRF } from '../stores/csrf.js';

export const checkUserIdResetKey = async (userId, resetKey) => {
  try{
    let params = {
      user_id: userId,
      reset_key: resetKey
    }
    let resp = await axios.post(
      '/check_reset_key', 
      JSON.stringify(params),
      {
        headers: {
          'Content-Type': 'application/json'
        }
      }
    );
    console.log(resp)
  }catch (error) {
    console.error(error);
    //window.location.href = '/error/access/404';
    return false;
  }
}

export const getUser = () => {
  return new Promise((resolve, reject) => {
    axios.get('access/user/info', {
      params: {},
      headers:{
        [CSRF.key]: CSRF.value,
      }
    }).then(function (response) {
      resolve(response);
    }).catch(function (error) {
      if(error.response.status == 404){
        console.error('Dentista no encontrado')
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

export const getMemberUser = (memberId) => {
  return new Promise((resolve, reject) => {
    axios.get(`admin/member/${memberId}/user`, {
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