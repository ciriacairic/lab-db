export interface GetComments {
  "user_id": number;
  "parent_id": string;
  "parent_type": string;
  "text": string;
  "thumbs_up": number;
  "thumbs_down": number;
  "created_at": string;
  "updated_at": string;
  "id": string;
}