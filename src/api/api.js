import axios from 'axios';

let base = 'http://localhost';

export const requestLogin = params => {
    var url = `${base}/admin/account/login`;
    console.log(url);
    return axios.post(url, params).then(res => res.data);
};
/*
*用户管理
**/
export const getUserList = params => { 
	return axios.get(`${base}/admin/user/list`, { params: params }); 
};

export const getUserListPage = params => { return axios.get(`${base}/admin/user/list`, { params: params }); };

export const removeUser = params => { return axios.get(`${base}/admin/user/remove`, { params: params }); };

export const batchRemoveUser = params => { return axios.get(`${base}/admin/user/batchremove`, { params: params }); };

export const editUser = params => { return axios.get(`${base}/admin/user/edit`, { params: params }); };

export const addUser = params => { return axios.get(`${base}/admin/user/add`, { params: params }); };
/*
*菜单管理
**/
export const getMenuList = params =>{
	return axios.get(`$base/admin/menu/list`,{params:params});
};