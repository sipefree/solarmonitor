//
//  SMAnimationDataSource.m
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMAnimationDataSource.h"


@implementation SMAnimationDataSource
@synthesize preloadedImages, anim_delegate;
- (id)initWithDelegate:(id <JSONDataSourceDelegate, SMAnimationDataSourceDelegate>)aDelegate {
	if((self = [super initWithURLString:@"http://solarmonitor.org/webservices/animation.json.php" delegate:aDelegate]) != nil) {
		// create space for the images that will be loaded
		preloadedImages = [[NSMutableDictionary alloc] init];
		
		// set the animation delegate to the json data source delegate
		anim_delegate = aDelegate;
	}
	return self;
}
- (void)preloadImages {
	// create a dictionary of frame names and urls for each
	NSMutableDictionary* imageLoaderDict = [NSMutableDictionary dictionary];
	int i = 0;
	for (NSString* img_url in [(NSDictionary*)[self jsonObject] objectForKey:@"images"]) {
		NSString* key = [NSString stringWithFormat:@"%i",i];
		NSURL* URL = [NSURL URLWithString:img_url];
		[imageLoaderDict setObject:URL forKey:key];
		i++;
	}
	// dispatch the image loader with these values
	loader = [[SMImageLoader alloc] initWithDictionary:preloadedImages delegate:self];
	[loader loadImagesFromKeysAndURLs:imageLoaderDict];
}

- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	// inform the animation delegate that a new frame has loaded,
	// so it can modify a progress bar or something similar.
	[anim_delegate animation:self didProgressWithCount:count ofTotal:total];
}
- (void)imageLoaderDidComplete:(SMImageLoader *)sender {
	// inform the animation delegate that all frames of the animation
	// have loaded and it can use the -preloadedImages method to retrieve
	// these frames for animation
	[anim_delegate animationDidFinishLoading:self];
	[loader release];
	loader = nil;
}
- (void)cancel {
	[loader cancel];
	[loader release];
	loader = nil;
}
- (void)flush {
	[loader flush];
}
@end
