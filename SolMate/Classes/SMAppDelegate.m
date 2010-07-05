//
//  SolMateAppDelegate.m
//  SolMate
//
//  Created by Simon Free on 28/05/2010.
//  Copyright SolarMonitor.org 2010. All rights reserved.
//

#import <CoreGraphics/CoreGraphics.h>
#import "SMAppDelegate.h"
#import "SMMainViewController.h"
#import "SMTabbedViewController.h"
#import "NSDate+yyyymmdd.h"
#import "SMPreferences.h"


@implementation SMAppDelegate

@synthesize window;
@synthesize mainViewController;
@synthesize activeRegionDataSource;
@synthesize imagesDataSource;
@synthesize animationDataSource;
@synthesize workingDate;
@synthesize forecastDataSource;

#pragma mark -
#pragma mark Application lifecycle

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions {
	// set the working date for the app to be the current date
	self.workingDate = [[NSDate alloc] initWithTimeIntervalSinceNow:0.0];
	
	// setup the preferences
	SMPreferences* prefs = [SMPreferences sharedPreferences];
	if([prefs defaultViewType] == nil) {
		[prefs setDefaultViewType:@"bbso_halph"];
	}
	
	// create the controller for the main view of the app and let it set up
    SMMainViewController *aController = [[SMMainViewController alloc] initWithNibName:@"MainView" bundle:nil];
	self.mainViewController = aController;
	[aController release];
	
	// create the data source for the active region list (pulls json from the web)
	activeRegionDataSource = [[SMActiveRegionDataSource alloc] initWithDelegate:self.mainViewController];
	[self.activeRegionDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	
	// create the data source for the list of image wavelengths available for the working date
	imagesDataSource = [[SMImagesDataSource alloc] initWithDelegate:nil];
	[self.imagesDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	
	// create the data source used for the animation on the main page and for the movie creator
	animationDataSource = [[SMAnimationDataSource alloc] initWithDelegate:self.mainViewController];
	[self.animationDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	
	// create the data source for forecasts and news
	forecastDataSource = [[SMForecastDataSource alloc] initWithDelegate:self.mainViewController];
	[self.forecastDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	
	// remove the status bar from the display
	window.frame = [UIScreen mainScreen].bounds;
    mainViewController.view.frame = [UIScreen mainScreen].bounds;
	[window addSubview:[mainViewController view]];
    [window makeKeyAndVisible];
	
	return YES;
	
}

- (void)setWorkingDate:(NSDate *)newDate {
	// set the new working date and update all the data sources with the new date
	workingDate = newDate;
	[self.activeRegionDataSource setValue:[NSString stringWithFormat:@"%i",[workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	[self.activeRegionDataSource update];
	[self.imagesDataSource setValue:[NSString stringWithFormat:@"%i",[workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	[self.imagesDataSource update];
	[self.forecastDataSource setValue:[NSString stringWithFormat:@"%i",[workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
}


- (void)applicationWillTerminate:(UIApplication *)application {
	// Save data if appropriate
}

// a helper function needed globally, so it resides in the app delegate singleton
// TODO: should probably move to a Helper class, but it's the only method needed there currently
CGImageRef CopyImageAndAddAlphaChannel(CGImageRef sourceImage) {
	CGImageRef retVal = NULL;
	
	size_t width = CGImageGetWidth(sourceImage);
	size_t height = CGImageGetHeight(sourceImage);
	
	CGColorSpaceRef colorSpace = CGColorSpaceCreateDeviceRGB();
	
	CGContextRef offscreenContext = CGBitmapContextCreate(NULL, width, height, 
														  8, 0, colorSpace, kCGImageAlphaPremultipliedFirst);
	
	if (offscreenContext != NULL) {
		CGContextDrawImage(offscreenContext, CGRectMake(0, 0, width, height), sourceImage);
		
		retVal = CGBitmapContextCreateImage(offscreenContext);
		CGContextRelease(offscreenContext);
	}
	
	CGColorSpaceRelease(colorSpace);
	
	return retVal;
}

// objc wrapper for the helper function
- (UIImage*)maskImage:(UIImage *)image withMask:(UIImage *)maskImage {
	CGImageRef maskRef = maskImage.CGImage;
	CGImageRef mask = CGImageMaskCreate(CGImageGetWidth(maskRef),
										CGImageGetHeight(maskRef),
										CGImageGetBitsPerComponent(maskRef),
										CGImageGetBitsPerPixel(maskRef),
										CGImageGetBytesPerRow(maskRef),
										CGImageGetDataProvider(maskRef), NULL, false);
	
	CGImageRef sourceImage = [image CGImage];
	CGImageRef imageWithAlpha = sourceImage;
	//add alpha channel for images that don't have one (ie GIF, JPEG, etc...)
	//this however has a computational cost
	if (CGImageGetAlphaInfo(sourceImage) == kCGImageAlphaNone) { 
		imageWithAlpha = CopyImageAndAddAlphaChannel(sourceImage);
	}
	
	CGImageRef masked = CGImageCreateWithMask(imageWithAlpha, mask);
	CGImageRelease(mask);
	
	//release imageWithAlpha if it was created by CopyImageAndAddAlphaChannel
	if (sourceImage != imageWithAlpha) {
		CGImageRelease(imageWithAlpha);
	}
	
	UIImage* retImage = [UIImage imageWithCGImage:masked];
	CGImageRelease(masked);
	
	return retImage;
}


#pragma mark -
#pragma mark Memory management

- (void)dealloc {
	[self.mainViewController release];
	[self.activeRegionDataSource release];
	[self.animationDataSource release];
	[self.imagesDataSource release];
	[self.forecastDataSource release];
	[self.workingDate release];
	[window release];
	[super dealloc];
}


@end

