import {format, parseISO} from "date-fns";

export const formatDateTime = (date) => {
    if (!date) {
        return '';
    }
    return format(
        parseISO(date),
        'yyyy-MM-dd HH:mm:ss'
    );
};
