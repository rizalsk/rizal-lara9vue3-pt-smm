import moment from 'moment';

export const formatDateString = (value, format = "YYYY-MM-DD HH:mm") => {
    return moment(value).format(format).toString();   
};