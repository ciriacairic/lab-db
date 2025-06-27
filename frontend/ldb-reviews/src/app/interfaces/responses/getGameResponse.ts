export interface GetGameResponse {
    "id": number,
    "name": string,
    "steam_appid": number,
    "required_age": number,
    "is_free": boolean,
    "dlc": [number],
    "detailed_description": string,
    "about_the_game": string,
    "short_description": string,
    "header_image": string,
    "capsule_image": string,
    "capsule_imagev5": string,
    "website": string,
    "platforms": {
        "windows": boolean,
        "mac": boolean,
        "linux": boolean
    },
    "metacritic": {
        "score": number,
        "url": string
    },
    "recommendations": {
        "total": number
    },
    "release_date": {
        "coming_soon": boolean,
        "date": string
    },
    "created_at": string,
    "updated_at": string,
    "technical_score": any,
    "subjective_score": any
}