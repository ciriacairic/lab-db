import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Backend } from '../../services/backend';
import { GetUserResponse } from '../../interfaces/responses/getUser';
import { Spinner } from "../../components/spinner/spinner";
import { Store } from '../../services/store';
import { NgClass } from '@angular/common';
@Component({
  selector: 'app-user',
  imports: [Spinner, NgClass],
  standalone: true,
  templateUrl: './user.html',
  styleUrl: './user.scss'
})
export class User {
  private _router = inject(Router);
  private _route = inject(ActivatedRoute);
  private _backendService = inject(Backend);
  private _store = inject(Store);

  userId = signal<string>('');
  currentTab = signal<number>(1);
  loading = signal<boolean>(true);
  loadingFollowers = signal<boolean>(true);
  showFollowersFollowingModal = signal<boolean>(false);
  followers = signal<any[]>([]);
  following = signal<any[]>([]);
  userInfo = signal<GetUserResponse>({} as GetUserResponse);
  
  constructor()
  {
    this._route.params.subscribe(params => {
      const userId = params['userId'];
      console.log(`User ID: ${userId}`);
      this.userId.set(userId);
      this._backendService.getUser(Number(userId)).subscribe({
        next: (user) => {
          if(user == '')
            this._router.navigate(['/']);
          console.log('User data:', user);
          this.loading.set(false);
          this.userInfo.set(user);
        },
        error: (error) => {
          console.error('Error fetching user data:', error);
        }
      });
    });
  }

  followedUser()
  {

  }

  closeFollowersFollowingModal()
  {
    this.showFollowersFollowingModal.set(false);
  }

  onFollowerFollowingClick(tab:number)
  {
    this.showFollowersFollowingModal.set(true);
    this.currentTab.set(tab);
    if(this.followers().length === 0 || this.following().length === 0)
    {
      this._backendService.getFollowers(Number(this.userId())).subscribe({
        next: (data) => {
          console.log('Followers data:', data);
          if(data.length === 0)
            this.followers.set([]);
          else
            this.followers.set(data);
          this._backendService.getFollowing(Number(this.userId())).subscribe({
            next: (data) => {
              console.log('Following data:', data);
              if(data.length === 0)
                this.following.set([]);
              else
                this.following.set(data);
              this.loadingFollowers.set(false);
            },
            error: (error) => {
              console.error('Error fetching following data:', error);
            }
          });
        },
        error: (error) => {
          console.error('Error fetching followers data:', error);
        }
      });
    }
  }

  changeTab(tab: number)
  {
    this.currentTab.set(tab);
  }

  onLibraryClick()
  {
    this._router.navigate(['/libraries', this.userId()]);
  }

  onLogoutClick()
  {
    console.log('Logging out user:', this.userId());
    this._store.removeItem('current_user').subscribe({
      next: () => {
        console.log('User logged out successfully');
        this._router.navigate(['/']);
      },
      error: (error) => {
        console.error('Error logging out:', error);
      }
    });
  }
}
