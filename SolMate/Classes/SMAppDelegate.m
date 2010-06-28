//
//  SolMateAppDelegate.m
//  SolMate
//
//  Created by Simon Free on 28/05/2010.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import <CoreGraphics/CoreGraphics.h>
#import "SMAppDelegate.h"
#import "SMMainViewController.h"
#import "SMTabbedViewController.h"
#import "NSDate+yyyymmdd.h"


@implementation SMAppDelegate

@synthesize window;
@synthesize mainViewController;
@synthesize activeRegionDataSource;
@synthesize imagesDataSource;
@synthesize animationDataSource;
@synthesize workingDate;

#pragma mark -
#pragma mark Application lifecycle

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions {
	self.workingDate = [[NSDate alloc] initWithTimeIntervalSinceNow:0.0];
	
    SMMainViewController *aController = [[SMMainViewController alloc] initWithNibName:@"MainView" bundle:nil];
	self.mainViewController = aController;
	[aController release];
	
	activeRegionDataSource = [[SMActiveRegionDataSource alloc] initWithDelegate:self.mainViewController];
	[self.activeRegionDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	[self.activeRegionDataSource update];
	
	imagesDataSource = [[SMImagesDataSource alloc] initWithDelegate:nil];
	[self.imagesDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	
	animationDataSource = [[SMAnimationDataSource alloc] initWithDelegate:self.mainViewController];
	[self.animationDataSource setValue:[NSString stringWithFormat:@"%i",[self.workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	[animationDataSource update];
	
	
	window.frame = [UIScreen mainScreen].bounds;
    mainViewController.view.frame = [UIScreen mainScreen].bounds;
	[window addSubview:[mainViewController view]];
    [window makeKeyAndVisible];
	
	return YES;
	
}

- (void)setWorkingDate:(NSDate *)newDate {
	workingDate = newDate;
	[self.activeRegionDataSource setValue:[NSString stringWithFormat:@"%i",[workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	[self.activeRegionDataSource update];
	[self.imagesDataSource setValue:[NSString stringWithFormat:@"%i",[workingDate dateAsYYYYMMDD]] forParameterKey:@"date"];
	[self.imagesDataSource update];
}


- (void)applicationWillTerminate:(UIApplication *)application {
	// Save data if appropriate
}

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
	[self.workingDate release];
	[window release];
	[super dealloc];
}


@end

