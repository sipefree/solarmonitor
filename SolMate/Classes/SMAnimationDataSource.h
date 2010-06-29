//
//  SMAnimationDataSource.h
//  SolMate
//
//  Created by Simon Free on 11/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "JSONDataSource.h"
#import "SMImageLoader.h"

@protocol SMAnimationDataSourceDelegate;

@interface SMAnimationDataSource : JSONDataSource <SMImageLoaderDelegate> {
	// this class has a separate delegate for animation loading messages as opposed
	// to json loading delegates, but in practise they are the same object
	id <SMAnimationDataSourceDelegate> anim_delegate;
	
	// a dictionary of the frames of the animation
	NSMutableDictionary* preloadedImages;
	
	// an instance of an asynchronous image loader
	SMImageLoader* loader;
}
- (id)initWithDelegate:(id <JSONDataSourceDelegate>)aDelegate;

// forces the data source to load each frame of the animation
- (void)preloadImages;

// cancels the loading of frames
- (void)cancel;

// removes all loaded frames from memory
- (void)flush;
@property (readonly) NSMutableDictionary* preloadedImages;
@property (nonatomic, assign) id <SMAnimationDataSourceDelegate> anim_delegate;
@end

@protocol SMAnimationDataSourceDelegate

- (void)animationDidFinishLoading:(SMAnimationDataSource*)sender;
- (void)animation:(SMAnimationDataSource*)sender didProgressWithCount:(int)count ofTotal:(int)total;
// - (void)animation:(SMAnimationDataSource*)sender didLoadImage:(UIImage*)image;
@end
