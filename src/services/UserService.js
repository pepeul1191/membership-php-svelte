import axios from 'axios';

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