//
//  SMMovieCreatorViewController.h
//  SolMate
//
//  Created by Simon Free on 24/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "SMMainViewController.h"
#import "SMImageLoader.h"
#import "SMAnimationDataSource.h"
#import "JSONDataSource.h"

@interface SMMovieCreatorViewController : SMFlipsideViewController <JSONDataSourceDelegate, SMAnimationDataSourceDelegate> {
	NSString* type;
	NSDate* startDate;
	NSDate* endDate;
	double fps;
	UIView* dateControlView;
	UIDatePicker* datePicker;
	UIButton* hideDateControlButton;
	BOOL settingStartDate;
	BOOL settingEndDate;
	BOOL animationNeedsUpdate;
	SMAnimationDataSource* animationDataSource;
	BOOL isLoading;
}
- (void)showDateControl;
- (void)hideDateControl;
- (IBAction)back;
- (IBAction)setStartDate;
- (IBAction)setEndDate;
- (IBAction)go;
- (IBAction)play;
- (IBAction)rewind;
- (IBAction)fastForward;
@property (nonatomic, retain) IBOutlet UIButton* startDateSetButton;
@property (nonatomic, retain) IBOutlet UIButton* endDateSetButton;
@property (nonatomic, retain) IBOutlet UIButton* goButton;
@property (nonatomic, retain) IBOutlet UIBarButtonItem* playButton;
@property (nonatomic, retain) IBOutlet UIBarButtonItem* rewindButton;
@property (nonatomic, retain) IBOutlet UIBarButtonItem* fastForwardButton;
@property (nonatomic, retain) IBOutlet UIProgressView* progressView;
@property (nonatomic, retain) IBOutlet UIImageView* imageView;
@property (nonatomic, retain) IBOutlet UITextField* fpsField;
@property (nonatomic, retain) IBOutlet UIActivityIndicatorView* activity;
@property (nonatomic, retain) IBOutlet UILabel* timeStamp;
@property (nonatomic, retain) NSString* type;
@property (nonatomic, assign) UIView* dateControlView;
@property (nonatomic, assign) UIDatePicker* datePicker;
@property (nonatomic, assign) UIButton* hideDateControlButton;

@end
