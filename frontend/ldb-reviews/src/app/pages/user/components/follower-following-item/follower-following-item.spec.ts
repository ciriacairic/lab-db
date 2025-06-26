import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FollowerFollowingItem } from './follower-following-item';

describe('FollowerFollowingItem', () => {
  let component: FollowerFollowingItem;
  let fixture: ComponentFixture<FollowerFollowingItem>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [FollowerFollowingItem]
    })
    .compileComponents();

    fixture = TestBed.createComponent(FollowerFollowingItem);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
