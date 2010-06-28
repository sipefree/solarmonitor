//
//  SMAnimationDataSource.m
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "SMAnimationDataSource.h"


@implementation SMAnimationDataSource
@synthesize preloadedImages, anim_delegate;
- (id)initWithDelegate:(id <JSONDataSourceDelegate, SMAnimationDataSourceDelegate>)aDelegate {
	if((self = [super initWithURLString:@"http://solarmonitor.org/webservices/animation.json.php" delegate:aDelegate]) != nil) {
		preloadedImages = [[NSMutableDictionary alloc] init];
		anim_delegate = aDelegate;
	}
	return self;
}
- (void)preloadImages {
	NSMutableDictionary* imageLoaderDict = [NSMutableDictionary dictionary];
	int i = 0;
	for (NSString* img_url in [(NSDictionary*)[self jsonObject] objectForKey:@"images"]) {
		NSString* key = [NSString stringWithFormat:@"%i",i];
		NSURL* URL = [NSURL URLWithString:img_url];
		[imageLoaderDict setObject:URL forKey:key];
		i++;
	}
	[loader release];
	loader = [[SMImageLoader alloc] initWithDictionary:preloadedImages delegate:self];
	[loader loadImagesFromKeysAndURLs:imageLoaderDict];
}

- (void)imageLoader:(SMImageLoader*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	[anim_delegate animation:self didProgressWithCount:count ofTotal:total];
}
- (void)imageLoaderDidComplete:(SMImageLoader *)sender {
	[anim_delegate animationDidFinishLoading:self];
	[loader release];
	loader = nil;
}
- (void)cancel {
	[loader cancel];
	[loader release];
	loader = nil;
}
@end
