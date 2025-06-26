import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class Store {

  guardarItem(item: string, value: string): Observable<void>
  {
    if(typeof localStorage != 'undefined')
      localStorage.setItem(item, value);
    return of();
  }

  getItem(item: string): Observable<string | null>
  {
    if(typeof localStorage != 'undefined')
      return of(localStorage.getItem(item));
    return of(null)
  }
}
