export function weatherUrl(icon: number) {
    if (icon < 10) {
        return `https://apidev.accuweather.com/developers/Media/Default/WeatherIcons/0${icon}-s.png`;
    }
    return `https://apidev.accuweather.com/developers/Media/Default/WeatherIcons/${icon}-s.png`;
}