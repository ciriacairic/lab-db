import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment.development';

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

  public getGames(
    gameId: string,
  ): Observable<any> {
    return this.http.get<any>(
      `${this.serverUrl}/game/${gameId}`, {
      headers: this.headers
    });
  }
}
