import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment.development';
import { PostUserRegisterPayload } from '../interfaces/requests/postUserRegisterPayload';
import { PostFollowPayload } from '../interfaces/requests/postFollowPayload';
import { PostCreateLibraryPayload } from '../interfaces/requests/postCreateLibraryPayload';
import { PostReviewPayload } from '../interfaces/requests/postReviewPayload';
import { PostCommentPayload } from '../interfaces/requests/postCommentPayload';
import { PostGameRequestPayload } from '../interfaces/requests/postGameRequestPayload';
import { PostGameRequestDecisionPayload } from '../interfaces/requests/postGameRequestDecisionPayload';
import { PostReportPayload } from '../interfaces/requests/postReportPayload';
import { PostReportDecicionPayload } from '../interfaces/requests/postReportDecisionPayload';
import { PostGamePayload } from '../interfaces/requests/postGamePayload';
import { GetGameResponse } from '../interfaces/responses/getGameResponse';
import { PostLoginPayload } from '../interfaces/requests/postLoginPayload';

@Injectable({
  providedIn: 'root'
})
export class Backend {

  private readonly serverUrl = environment.BACKEND_URL;
  private headers = new HttpHeaders();

  constructor(
    private http: HttpClient
  )
  {
    this.headers.set("Accept", "application/json");
    this.headers.set("Content-Type", "application/json");
  }

  public postLogin(
    loginPayload: PostLoginPayload,
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/login`, loginPayload, {
      headers: this.headers
    });
  }

  public postUser(
    registerPayload: PostUserRegisterPayload,
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/users`, registerPayload,{
      headers: this.headers
    });
  }

  public getFollowers(
    userId: number,
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/followers/${userId}`,{
      headers: this.headers
    });
  }

  public getFollowing(
    userId: number,
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/following/${userId}`,{
      headers: this.headers
    });
  }

  public getUser(
    userId: number,
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/user/${userId}`,{
      headers: this.headers
    });
  }

  public postBanUser(
    userId: number,
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/user/${userId}/ban`,{
      headers: this.headers
    });
  }

  public deleteUser(
    userId: number,
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/user/${userId}`,{
      headers: this.headers
    });
  }

  public postFollowUser(
    postFollowPayload: PostFollowPayload,
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/user/follow`, postFollowPayload, {
      headers: this.headers
    });
  }

  public postEditUser(
    userId: number,
    userParams: HttpParams
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/user/${userId}`, {
      params: userParams,
      headers: this.headers
    });
  }

  public getUserLibraries(
    userId: number
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/user/${userId}/library`, {
      headers: this.headers
    });
  }

  public getUserReviews(
    userId: number
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/user/${userId}/review`, {
      headers: this.headers
    });
  }

  public getUserComments(
    userId: number
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/user/${userId}/comment`, {
      headers: this.headers
    });
  }

  public postLibrary(
    postLibraryPayload: PostCreateLibraryPayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/library`, postLibraryPayload, {
      headers: this.headers
    });
  }

  public deleteLibrary(
    libraryId: number
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/library/${libraryId}`, {
      headers: this.headers
    });
  }

  public postAddGameLibrary(
    libraryId: number,
    gameId: number
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/library/${libraryId}/add_game/${gameId}`, {
      headers: this.headers
    });
  }

  public removeGameLibrary(
    libraryId: number,
    gameId: number
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/library/${libraryId}/remove_game/${gameId}`, {
      headers: this.headers
    });
  }

  public getLibrary(
    libraryId: number
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/library/${libraryId}`, {
      headers: this.headers
    });
  }

  public postReview(
    postReviewPayload: PostReviewPayload,
  ): Observable<any> {
    let params = new HttpParams()
      .set('game_id', postReviewPayload.game_id)
      .set('user_id', postReviewPayload.user_id)
      .set('markdown_text', postReviewPayload.markdown_text)
      .set('scores[gameplay]', JSON.stringify(postReviewPayload.scores.gameplay))
      .set('scores[graphics]', JSON.stringify(postReviewPayload.scores.graphics))
      .set('scores[sound]', JSON.stringify(postReviewPayload.scores.sound))
      .set('scores[story]', JSON.stringify(postReviewPayload.scores.story))
      .set('scores[nostalgic]', JSON.stringify(postReviewPayload.scores.nostalgic));
    return this.http.post<any>(
      `${this.serverUrl}/api/review`, postReviewPayload, {
      params: params,
      headers: this.headers
    });
  }

  public deleteReview(
    reviewId: string
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/review/${reviewId}`, {
      headers: this.headers
    });
  }

  public getComments(
    parentId: number,
    parentType: string
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/comment/${parentId}/${parentType}`, {
      headers: this.headers
    });
  }

  public postComment(
    postCommentPayload: PostCommentPayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/comment/`, postCommentPayload,{
      headers: this.headers
    });
  }

  public deleteComment(
    commentId: string
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/comment/${commentId}`, {
      headers: this.headers
    });
  }

  public postGameRequest(
    postGameRequestPayload: PostGameRequestPayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/game_request`, postGameRequestPayload, {
      headers: this.headers
    });
  }

  public postGameRequestDecision(
    gameRequestId: number,
    postGameRequestDecisionPayload: PostGameRequestDecisionPayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/game_request/${gameRequestId}`, postGameRequestDecisionPayload, {
      headers: this.headers
    });
  }

  public deleteGameRequest(
    gameRequestId: number
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/game_request/${gameRequestId}`, {
      headers: this.headers
    });
  }

  public getGameRequests(): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/game_request`, {
      headers: this.headers
    });
  }

  public postReport(
    postReportPayload: PostReportPayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/report`, postReportPayload, {
      headers: this.headers
    });
  }

  public postReportDecision(
    reportId: string,
    postReportDecisionPayload: PostReportDecicionPayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/report/${reportId}`, postReportDecisionPayload, {
      headers: this.headers
    });
  }

  public getReports(): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/report`, {
      headers: this.headers
    });
  }

  public deleteReport(
    reportId: string
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/report/${reportId}`, {
      headers: this.headers
    });
  }

  public getGameReviews(
    gameId: number
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/game/${gameId}/reviews`, {
      headers: this.headers
    });
  }

  public getGameSearch(
    searchQuery: string
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/game/search/${searchQuery}`, {
      headers: this.headers
    });
  }

  public getGame(
    gameId: number
  ): Observable<GetGameResponse> {
    return this.http.get<any>(
      `${this.serverUrl}/api/game/${gameId}`, {
      headers: this.headers
    });
  }

  public postGame(
    postGamePayload: PostGamePayload
  ): Observable<any> {
    return this.http.post<any>(
      `${this.serverUrl}/api/game`, postGamePayload, {
      headers: this.headers
    });
  }

  public deleteGame(
    gameId: number
  ): Observable<any> {
    return this.http.delete<any>(
      `${this.serverUrl}/api/game/${gameId}`, {
      headers: this.headers
    });
  }

  public getHomeRecomendations(
    userId: number
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/api/home/${userId}`, {
      headers: this.headers
    });
  }
}
