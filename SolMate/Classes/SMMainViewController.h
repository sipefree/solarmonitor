//
//  SMMainViewController.h
//  Sol Mate
//
//  Created by Simon Free on 08/06/2010.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import "SMFlipsideViewController.h"
#import "JSONDataSource.h"
#import "SMSmallARListCell.h"
#import "SMAnimationDataSource.h"
@class SMTabbedViewController;

@interface SMMainViewController : UIViewController <SMFlipsideViewControllerDelegate, JSONDataSourceDelegate, SMAnimationDataSourceDelegate> {
	IBOutlet UITabBar* _tabBar;
	IBOutlet UILabel* _defaultImageType;
	IBOutlet UILabel* _defaultImageTime;
	IBOutlet UIImageView* _defaultImageView;
	IBOutlet UITableView* _smallARList;
	IBOutlet UIActivityIndicatorView* _activityIndicator;
	IBOutlet UIView* _tabContentView;
	IBOutlet UIView* _dateControlView;
	IBOutlet UIDatePicker* _datePicker;
	IBOutlet UIProgressView* _progressView;
	IBOutlet UIButton* _hideDateControlButton;
	IBOutlet UIButton* _toggleAnimationButton;
	IBOutlet SMTabbedViewController* _tabbedViewController;
	IBOutlet SMSmallARListCell* _tmpCell;
	BOOL animationLoaded;
}

- (IBAction)showInfo;
- (IBAction)showDateControl;
- (IBAction)hideDateControl;
- (IBAction)dateControlGotoToday;
- (IBAction)dateControlBackRotation;
- (IBAction)dateControlBackWeek;
- (IBAction)dateControlForwardWeek;
- (IBAction)dateControlForwardRotation;
- (IBAction)toggleAnimation;
- (void)showImageDetailViewWithData:(NSDictionary* )dict;
- (void)showMovieCreatorForType:(NSString *)type;
- (void)dataSourceDidStartLoading:(JSONDataSource*)ds;
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds;
- (void)animationDidFinishLoading:(SMAnimationDataSource*)sender;
- (void)updateDefaultViewWithDictionary:(NSDictionary*)dict;

@property(nonatomic, retain) UITabBar* tabBar;
@property(nonatomic, retain) UILabel* defaultImageType;
@property(nonatomic, retain) UILabel* defaultImageTime;
@property(nonatomic, retain) UIImageView* defaultImageView;
@property(nonatomic, retain) UITableView* smallARList;
@property(nonatomic, retain) UIActivityIndicatorView* activityIndicator;
@property(nonatomic, assign) SMSmallARListCell *tmpCell;
@property(nonatomic, retain) UIView *tabContentView;
@property(nonatomic, retain) SMTabbedViewController* tabbedViewController;
@property(nonatomic, retain) UIView* dateControlView;
@property(nonatomic, retain) UIDatePicker* datePicker;
@property(nonatomic, retain) UIProgressView* progressView;
@property(nonatomic, retain) UIButton* hideDateControlButton;
@property(nonatomic, retain) UIButton* toggleAnimationButton;
@end
