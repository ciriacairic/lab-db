import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReviewWrite } from './review-write.component';

describe('ReviewWrite', () => {
  let component: ReviewWrite;
  let fixture: ComponentFixture<ReviewWrite>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ReviewWrite]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ReviewWrite);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
