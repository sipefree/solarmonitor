//
//  SMAnimationDataSource.h
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "JSONDataSource.h"
#import "SMImageLoader.h"

@protocol SMAnimationDataSourceDelegate;

@interface SMAnimationDataSource : JSONDataSource <SMImageLoaderDelegate> {
	id <SMAnimationDataSourceDelegate> anim_delegate;
	NSMutableDictionary* preloadedImages;
	CFMutableDictionaryRef connectionToInfoMapping;
	SMImageLoader* loader;
}
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate;
- (void)preloadImages;
- (void)cancel;
@property (readonly) NSMutableDictionary* preloadedImages;
@property (nonatomic, assign) id <SMAnimationDataSourceDelegate> anim_delegate;
@end

@protocol SMAnimationDataSourceDelegate

- (void)animationDidFinishLoading:(SMAnimationDataSource*)sender;
- (void)animation:(SMAnimationDataSource*)sender didProgressWithCount:(int)count ofTotal:(int)total;
// - (void)animation:(SMAnimationDataSource*)sender didLoadImage:(UIImage*)image;
@end
