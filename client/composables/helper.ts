export function getShortNameAvatar(name: string) {
    let splitName = name.split(' ')
    if (splitName.length > 1) {
        return splitName[0][0] + splitName.slice(-1)[0]
    }
    return splitName[0][0]
}

export function makeid(length: number) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }
    return result;
}