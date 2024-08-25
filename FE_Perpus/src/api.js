import axios from "axios";

const costumAPI = axios.create({
    baseURL: " http://localhost:8000/api/v1",
});

export const tokenApi = axios.create({
    baseURL: " http://localhost:8000/api/v1",
    headers: { 'Authorization': `Bearer ${localStorage.getItem('token')}` }
});

export default costumAPI