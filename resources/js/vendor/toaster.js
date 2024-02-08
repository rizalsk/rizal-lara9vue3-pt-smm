export const notify = (type = 'info', message = "Hello") => {
    toast(message, {
        "theme": "colored",
        "type": type,
        "dangerouslyHTMLString": true,
        rtl: true ,
    })
    return false;
}