//
//  SMTabbedViewController.h
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Foundation/Foundation.h>
#import "JSONDataSource.h"
@class SMMainViewController;
@class SMListCell;

@interface SMTabbedViewController : UIViewController <JSONDataSourceDelegate> {
    IBOutlet SMMainViewController *controller;
    IBOutlet UIButton *forecastButton;
    IBOutlet UIView *forecastView;
    IBOutlet UIButton *imagesButton;
    IBOutlet UIView *imagesView;
    IBOutlet UIButton *moviesButton;
    IBOutlet UIView *moviesView;
	IBOutlet UITableView* imagesTable;
	IBOutlet UITableView* moviesTable;
	IBOutlet UITableView* forecastTable;
	UIButton* activeButton;
	UIView* activeView;
	IBOutlet SMListCell* tmpCell;
	
}
- (IBAction)showForecastView:(UIButton *)sender;
- (IBAction)showImagesView:(UIButton *)sender;
- (IBAction)showMoviesView:(UIButton *)sender;

- (void)dataSourceDidStartLoading:(JSONDataSource*)ds;
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds;

- (void)tablesNeedUpdate;

@property (nonatomic, assign) SMListCell* tmpCell;
@end
