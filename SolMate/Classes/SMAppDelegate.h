//
//  SMAppDelegate.h
//  SolMate
//
//  Created by Simon Free on 28/05/2010.
//  Copyright SolarMonitor.org 2010. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "SMMainViewController.h"
#import "SMFlipsideViewController.h"
#import "SMActiveRegionDataSource.h"
#import "SMImagesDataSource.h"
#import "SMAnimationDataSource.h"
#import "SMForecastDataSource.h"

@interface SMAppDelegate : NSObject <UIApplicationDelegate> {
    UIWindow *window;
	NSDate* workingDate;
    SMMainViewController * mainViewController;
	SMActiveRegionDataSource* activeRegionDataSource;
	SMImagesDataSource* imagesDataSource;
	SMAnimationDataSource* animationDataSource;
	SMForecastDataSource* forecastDataSource;
}
- (UIImage*)maskImage:(UIImage *)image withMask:(UIImage *)maskImage;
@property (nonatomic, retain) IBOutlet UIWindow *window;
@property (nonatomic, retain) SMMainViewController *mainViewController;
@property (readonly) SMActiveRegionDataSource *activeRegionDataSource;
@property (readonly) SMImagesDataSource* imagesDataSource;
@property (readonly) SMAnimationDataSource* animationDataSource;
@property (readonly) SMForecastDataSource* forecastDataSource;
@property (nonatomic, retain) NSDate* workingDate;
@end

