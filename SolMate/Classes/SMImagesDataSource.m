//
//  SMImagesDataSource.m
//  SolMate
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "SMImagesDataSource.h"
#import "SMAppDelegate.h"
#import <UIKit/UIKit.h>
#import "SMTabbedViewController.h"

@implementation SMImagesDataSource
@synthesize preloadedImages;
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate {
	if((self = [super initWithURLString:@"http://solarmonitor.org/webservices/thumbnails.json.php" delegate:aDelegate]) != nil) {
		preloadedImages = [[NSMutableDictionary alloc] init];
	}
	return self;
}
- (NSArray *)thumbnails {
	NSDictionary* dict = (NSDictionary*)self.jsonObject;
	NSArray* thumbnails = [dict objectForKey:@"imageSources"];
	return thumbnails;
}
- (void)update {
	[preloadedImages removeAllObjects];
	[super update];
}
- (void)preloadImages {
	NSMutableDictionary* imageLoaderDict = [NSMutableDictionary dictionary];
	for (NSDictionary* dict in [self thumbnails]) {
		NSString* key = [dict objectForKey:@"type"];
		NSString* imgUrl = [dict objectForKey:@"image"];
		NSURL* URL = [NSURL URLWithString:imgUrl];
		[imageLoaderDict setObject:URL forKey:key];
	}
	//[loader release];
	loader = [[SMImageLoader alloc] initWithDictionary:preloadedImages delegate:self];
	[loader loadImagesFromKeysAndURLs:imageLoaderDict];
}
- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	[(SMTabbedViewController*)self.delegate tablesNeedUpdate];
}
- (void)imageLoaderDidComplete:(SMImageLoader *)sender {
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	SMMainViewController* controller = appDelegate.mainViewController;
	NSString* key = @"bbso_halph";
	if([preloadedImages objectForKey:key] == nil) {
		key = [[preloadedImages allKeys] objectAtIndex:0];
	}
	NSDictionary* dict;
	for (dict in [self thumbnails]) {
		if([[dict objectForKey:@"type"] isEqualToString:key])
			break;
	}
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
