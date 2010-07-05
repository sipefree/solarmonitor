//
//  SMImagesDataSource.m
//  SolMate
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMImagesDataSource.h"
#import "SMAppDelegate.h"
#import <UIKit/UIKit.h>
#import "SMTabbedViewController.h"
#import "SMPreferences.h"

@implementation SMImagesDataSource
@synthesize preloadedImages;
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate {
	if((self = [super initWithURLString:@"http://solarmonitor.org/webservices/thumbnails.json.php" delegate:aDelegate]) != nil) {
		// create the dictionary to hold the images that will
		// be loaded bu the SMImageLoader
		preloadedImages = [[NSMutableDictionary alloc] init];
	}
	return self;
}
- (NSArray *)thumbnails {
	// the imageSources key of the data source contains the URLs of
	// thumbnails it will load, along with some other information
	// about each image type
	NSDictionary* dict = (NSDictionary*)self.jsonObject;
	NSArray* thumbnails = [dict objectForKey:@"imageSources"];
	return thumbnails;
}
- (void)update {
	// flush the preloaded images before updating the data source
	[preloadedImages removeAllObjects];
	[super update];
}
- (void)preloadImages {
	// create a dictionary where each key is the image type and each value
	// is the URL of the thumbnail for that image type
	NSMutableDictionary* imageLoaderDict = [NSMutableDictionary dictionary];
	for (NSDictionary* dict in [self thumbnails]) {
		NSString* key = [dict objectForKey:@"type"];
		NSString* imgUrl = [dict objectForKey:@"image"];
		NSURL* URL = [NSURL URLWithString:imgUrl];
		[imageLoaderDict setObject:URL forKey:key];
	}
	// give the dictionary to the loader and dispatch it
	loader = [[SMImageLoader alloc] initWithDictionary:preloadedImages delegate:self];
	[loader loadImagesFromKeysAndURLs:imageLoaderDict];
}
- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	// when a new image is loaded, the tables on the main view will
	// be updated to show it
	[(SMTabbedViewController*)self.delegate tablesNeedUpdate];
}
- (void)imageLoaderDidComplete:(SMImageLoader *)sender {
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	
	// get the main view controller
	SMMainViewController* controller = appDelegate.mainViewController;
	
	// get the default image for the top half of the main view
	SMPreferences* prefs = [SMPreferences sharedPreferences];
	NSString* key = [prefs defaultViewType];
	
	// if this doesn't exist, take the first key in the list
	if([preloadedImages objectForKey:key] == nil) {
		key = [[preloadedImages allKeys] objectAtIndex:0];
	}
	
	// search in the thumbnails for the key used, in order
	// to get the metadata associated with that key
	NSDictionary* dict;
	for (dict in [self thumbnails]) {
		if([[dict objectForKey:@"type"] isEqualToString:key])
			break;
	}
	
	// tell the controller to update the top half of the main view
	// with the information loaded
	[controller updateDefaultViewWithDictionary:[NSDictionary dictionaryWithObjectsAndKeys:
						[preloadedImages objectForKey:key],@"image",
						key,@"type",
						[dict objectForKey:@"time"],@"time",
						nil]
	 ];
	[sender release];
}
- (void)dealloc {
	[preloadedImages release];
	[super dealloc];
}
@end
