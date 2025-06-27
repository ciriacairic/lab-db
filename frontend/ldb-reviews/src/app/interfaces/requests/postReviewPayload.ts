import { Scores } from "./scores";

export interface PostReviewPayload {
  "game_id": number;
  "user_id": number;
  "markdown_text": string;
  "scores": Scores
}