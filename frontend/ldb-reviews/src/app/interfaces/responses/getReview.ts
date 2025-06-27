import { Scores } from "../requests/scores";

export interface GetReview{
  "game_id": number;
  "user_id": number;
  "markdown_text": string;
  "scores": Scores;
  "id": string;
  "created_at": string;
  'username': string;
}